<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ;

use AMQPChannelException;
use AMQPConnectionException;
use AMQPExchangeException;
use AMQPQueue;
use Common\Domain\Bus\Event\DomainEventSubscriberInterface;
use Common\Infrastructure\Bus\Event\RabbitMQ\Formatter\RabbitMqExchangeNameFormatter;
use Common\Infrastructure\Bus\Event\RabbitMQ\Formatter\RabbitMqQueueNameFormatter;


final class RabbitMqConfigurer
{
    private RabbitMqConnection $connection;

    /**
     * Constructor for RabbitMqConfigurer.
     *
     * @param RabbitMqConnection $connection Connection instance for RabbitMQ.
     */
    public function __construct(RabbitMqConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Configures exchanges and queues for the given subscribers.
     *
     * @param string $exchangeName Name of the main exchange.
     * @param DomainEventSubscriberInterface ...$subscribers The event subscribers.
     */
    public function configure(string $exchangeName, DomainEventSubscriberInterface ...$subscribers): void
    {
        // Declare exchanges for retry and dead letter mechanisms.
        $retryExchangeName = RabbitMqExchangeNameFormatter::retry($exchangeName);
        $deadLetterExchangeName = RabbitMqExchangeNameFormatter::deadLetter($exchangeName);

        $this->declareExchange($exchangeName);
        $this->declareExchange($retryExchangeName);
        $this->declareExchange($deadLetterExchangeName);

        $this->declareQueues($exchangeName, $retryExchangeName, $deadLetterExchangeName, ...$subscribers);
    }

    /**
     * Declares an exchange in RabbitMQ.
     *
     * @param string $exchangeName Name of the exchange to declare.
     */
    private function declareExchange(string $exchangeName): void
    {
        $exchange = $this->connection->exchange($exchangeName);
        $exchange->setType(AMQP_EX_TYPE_TOPIC);
        $exchange->setFlags(AMQP_DURABLE);
        try {
            $exchange->declareExchange();
        } catch (AMQPChannelException|AMQPConnectionException|AMQPExchangeException) {
        }
    }

    /**
     * Declares the necessary queues for the given subscribers.
     *
     * @param string $exchangeName Main exchange name.
     * @param string $retryExchangeName Retry exchange name.
     * @param string $deadLetterExchangeName Dead letter exchange name.
     * @param DomainEventSubscriberInterface ...$subscribers Event subscribers.
     */
    private function declareQueues(
        string                         $exchangeName,
        string                         $retryExchangeName,
        string                         $deadLetterExchangeName,
        DomainEventSubscriberInterface ...$subscribers
    ): void
    {
        foreach ($subscribers as $subscriber) {
            $this->declareSubscriberQueues($subscriber, $exchangeName, $retryExchangeName, $deadLetterExchangeName);
        }
    }

    /**
     * Declares queues for a specific subscriber.
     *
     * @param DomainEventSubscriberInterface $subscriber The event subscriber.
     * @param string $exchangeName Main exchange name.
     * @param string $retryExchangeName Retry exchange name.
     * @param string $deadLetterExchangeName Dead letter exchange name.
     */
    private function declareSubscriberQueues(
        DomainEventSubscriberInterface $subscriber,
        string                         $exchangeName,
        string                         $retryExchangeName,
        string                         $deadLetterExchangeName
    ): void
    {
        $queueName = RabbitMqQueueNameFormatter::format($subscriber);
        $retryQueueName = RabbitMqQueueNameFormatter::formatRetry($subscriber);
        $deadLetterQueueName = RabbitMqQueueNameFormatter::formatDeadLetter($subscriber);

        $queue = $this->declareQueue($queueName);
        $retryQueue = $this->declareQueue($retryQueueName, $exchangeName, $queueName, 1000);
        $deadLetterQueue = $this->declareQueue($deadLetterQueueName);

        try {
            $queue->bind($exchangeName, $queueName);
        } catch (AMQPChannelException|AMQPConnectionException) {
        }
        try {
            $retryQueue->bind($retryExchangeName, $queueName);
        } catch (AMQPChannelException|AMQPConnectionException) {
        }
        try {
            $deadLetterQueue->bind($deadLetterExchangeName, $queueName);
        } catch (AMQPChannelException|AMQPConnectionException) {
        }

        foreach ($subscriber::subscribedTo() as $eventClass) {
            try {
                $queue->bind($exchangeName, $eventClass::eventName());
            } catch (AMQPChannelException|AMQPConnectionException) {
            }
        }
    }

    /**
     * Declares a queue in RabbitMQ.
     *
     * @param string $name Queue name.
     * @param string|null $deadLetterExchange Dead letter exchange name.
     * @param string|null $deadLetterRoutingKey Dead letter routing key.
     * @param int|null $messageTtl Time-to-live for messages in milliseconds.
     * @return AMQPQueue The declared queue.
     */
    private function declareQueue(
        string  $name,
        ?string $deadLetterExchange = null,
        ?string $deadLetterRoutingKey = null,
        ?int    $messageTtl = null
    ): AMQPQueue
    {
        $queue = $this->connection->queue($name);

        if ($deadLetterExchange !== null) {
            $queue->setArgument('x-dead-letter-exchange', $deadLetterExchange);
        }

        if ($deadLetterRoutingKey !== null) {
            $queue->setArgument('x-dead-letter-routing-key', $deadLetterRoutingKey);
        }

        if ($messageTtl !== null) {
            $queue->setArgument('x-message-ttl', $messageTtl);
        }

        $queue->setFlags(AMQP_DURABLE);
        try {
            $queue->declareQueue();
        } catch (AMQPChannelException|AMQPConnectionException|\AMQPQueueException) {
            //TODO catch
        }

        return $queue;
    }
}
