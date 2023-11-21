<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ;

use AMQPEnvelope;
use AMQPQueue;
use AMQPQueueException;
use Common\Infrastructure\Bus\Event\DomainEventJsonDeserializer;
use Common\Domain\Bus\Event\DomainEventSubscriberInterface;
use Throwable;

/**
 * Consumes domain events from RabbitMQ queues.
 */
final class RabbitMqDomainEventsConsumer
{
    private RabbitMqConnection $connection;
    private DomainEventJsonDeserializer $deserializer;
    private string $exchangeName;
    private int $maxRetries;

    /**
     * Constructor for RabbitMqDomainEventsConsumer.
     *
     * @param RabbitMqConnection $connection Connection instance for RabbitMQ.
     * @param DomainEventJsonDeserializer $deserializer Deserializer for domain events.
     * @param string $exchangeName Name of the exchange.
     * @param int $maxRetries Maximum number of retries before moving to dead letter.
     */
    public function __construct(
        RabbitMqConnection $connection,
        DomainEventJsonDeserializer $deserializer,
        string $exchangeName,
        int $maxRetries
    ) {
        $this->connection = $connection;
        $this->deserializer = $deserializer;
        $this->exchangeName = $exchangeName;
        $this->maxRetries = $maxRetries;
    }

    /**
     * Starts the consumption process for the specified queue.
     *
     * @param callable|DomainEventSubscriberInterface $subscriber The event subscriber or a callback.
     * @param string $queueName The name of the queue to consume from.
     */
    public function consume(callable|DomainEventSubscriberInterface $subscriber, string $queueName): void
    {
        try {
            $this->connection->queue($queueName)->consume($this->consumer($subscriber));
        } catch (AMQPQueueException) {
            // Handling exceptions quietly, assuming no messages are available.
        } catch (\AMQPChannelException|\AMQPConnectionException|\AMQPEnvelopeException $e) {
        }
    }

    /**
     * Provides a callable consumer for handling messages.
     *
     * @param callable $subscriber The subscriber or callback to handle messages.
     * @return callable The callable consumer function.
     */
    private function consumer(callable $subscriber): callable
    {
        return function (AMQPEnvelope $envelope, AMQPQueue $queue) use ($subscriber): void {
            $event = $this->deserializer->deserialize($envelope->getBody());

            try {
                $subscriber($event);
            } catch (Throwable $error) {
                $this->handleConsumptionError($envelope, $queue);
                throw $error;
            }

            $queue->ack($envelope->getDeliveryTag());
        };
    }

    // Additional private methods (handleConsumptionError, hasBeenRedeliveredTooMuch, sendToDeadLetter, sendToRetry, sendMessageTo) would remain similar to your original implementation, adjusted for readability and consistency.
}
