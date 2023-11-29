<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ;

use Common\Domain\Bus\Event\DomainEventSubscriberInterface;
use Common\Infrastructure\Bus\Event\DomainEventJsonDeserializer;
use Common\Infrastructure\Bus\Event\RabbitMQ\Formatter\RabbitMqExchangeNameFormatter;

final readonly class RabbitMqDomainEventsConsumer
{
    /**
     * Initializes the RabbitMqDomainEventsConsumer with necessary dependencies.
     *
     * @param RabbitMqConnection          $connection   connection to RabbitMQ
     * @param DomainEventJsonDeserializer $deserializer deserializer for domain events
     * @param string                      $exchangeName name of the exchange to use
     * @param int                         $maxRetries   maximum number of retries before moving to a dead letter queue
     */
    public function __construct(
        private RabbitMqConnection $connection,
        private DomainEventJsonDeserializer $deserializer,
        private string $exchangeName,
        private int $maxRetries
    ) {
    }

    /**
     * Consumes messages from the specified queue and processes them using the provided subscriber.
     *
     * @param callable|DomainEventSubscriberInterface $subscriber the event subscriber or a callback function
     * @param string                                  $queueName  the name of the queue to consume from
     */
    public function consume(callable|DomainEventSubscriberInterface $subscriber, string $queueName): void
    {
        try {
            $this->connection->queue($queueName)->consume($this->consumer($subscriber));
        } catch (\AMQPQueueException|\AMQPChannelException|\AMQPConnectionException|\AMQPEnvelopeException) {
            // TODO catch
        }
    }

    /**
     * Provides a consumer callable for handling messages from the queue.
     *
     * @param callable|DomainEventSubscriberInterface $subscriber the subscriber or callback function to process messages
     *
     * @return callable the consumer function
     */
    private function consumer(callable|DomainEventSubscriberInterface $subscriber): callable
    {
        return function (\AMQPEnvelope $envelope, \AMQPQueue $queue) use ($subscriber): void {
            $event = $this->deserializer->deserialize($envelope->getBody());

            try {
                if (is_callable($subscriber)) {
                    $subscriber($event);
                }
            } catch (\Throwable $error) {
                $this->handleConsumptionError($envelope, $queue);
                throw $error;
            }

            $queue->ack($envelope->getDeliveryTag());
        };
    }

    /**
     * Handles errors that occur during message consumption.
     *
     * @param \AMQPEnvelope $envelope the envelope of the message
     * @param \AMQPQueue    $queue    the queue from which the message was consumed
     */
    private function handleConsumptionError(\AMQPEnvelope $envelope, \AMQPQueue $queue): void
    {
        $this->hasBeenRedeliveredTooMuch($envelope)
            ? $this->sendToDeadLetter($envelope, $queue)
            : $this->sendToRetry($envelope, $queue);

        try {
            $queue->ack($envelope->getDeliveryTag());
        } catch (\AMQPChannelException|\AMQPConnectionException) {
            // TODO catch
        }
    }

    /**
     * Checks if the message has been redelivered beyond the maximum retry limit.
     *
     * @param \AMQPEnvelope $envelope the message envelope
     *
     * @return bool whether the message has exceeded the retry limit
     */
    private function hasBeenRedeliveredTooMuch(\AMQPEnvelope $envelope): bool
    {
        $headers = $envelope->getHeaders();
        $redeliveryCount = $headers['redelivery_count'] ?? 0;

        return $redeliveryCount >= $this->maxRetries;
    }

    /**
     * Sends the message to the dead letter exchange.
     *
     * @param \AMQPEnvelope $envelope the envelope of the message
     * @param \AMQPQueue    $queue    the queue from which the message was consumed
     */
    private function sendToDeadLetter(\AMQPEnvelope $envelope, \AMQPQueue $queue): void
    {
        $this->sendMessageTo(RabbitMqExchangeNameFormatter::deadLetter($this->exchangeName), $envelope, $queue);
    }

    /**
     * Sends the message to the retry exchange.
     *
     * @param \AMQPEnvelope $envelope the envelope of the message
     * @param \AMQPQueue    $queue    the queue from which the message was consumed
     */
    private function sendToRetry(\AMQPEnvelope $envelope, \AMQPQueue $queue): void
    {
        $this->sendMessageTo(RabbitMqExchangeNameFormatter::retry($this->exchangeName), $envelope, $queue);
    }

    /**
     * Publishes the message to the specified exchange.
     *
     * @param string        $exchangeName the name of the exchange to publish the message
     * @param \AMQPEnvelope $envelope     the envelope of the message
     * @param \AMQPQueue    $queue        the queue from which the message was consumed
     */
    private function sendMessageTo(string $exchangeName, \AMQPEnvelope $envelope, \AMQPQueue $queue): void
    {
        $headers = $envelope->getHeaders();
        $headers['redelivery_count'] = ($headers['redelivery_count'] ?? 0) + 1;

        try {
            $this->connection->exchange($exchangeName)->publish(
                $envelope->getBody(),
                $queue->getName(),
                AMQP_NOPARAM,
                [
                    'message_id' => $envelope->getMessageId(),
                    'content_type' => $envelope->getContentType(),
                    'content_encoding' => $envelope->getContentEncoding(),
                    'priority' => $envelope->getPriority(),
                    'headers' => $headers,
                ]
            );
        } catch (\AMQPChannelException|\AMQPConnectionException|\AMQPExchangeException) {
            // TODO catch
        }
    }
}
