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
use Exception;

final readonly class RabbitMqConfigure
{
    public function __construct(
        private RabbitMqConnection $connection
    ){
    }

    /**
     * Configures exchanges and queues for the given subscribers.
     *
     * @param string $exchangeName Name of the main exchange.
     * @param DomainEventSubscriberInterface ...$subscribers The event subscribers.
     * @throws Exception
     */
    public function configure(string $exchangeName, DomainEventSubscriberInterface ...$subscribers): void
    {
        // Formatting exchange names using static methods for readability
        $retryExchangeName = RabbitMqExchangeNameFormatter::retry($exchangeName);
        $deadLetterExchangeName = RabbitMqExchangeNameFormatter::deadLetter($exchangeName);

        // Declaring exchanges using a simplified method
        $this->declareExchange($exchangeName);
        $this->declareExchange($retryExchangeName);
        $this->declareExchange($deadLetterExchangeName);

        // Declaring queues for each subscriber
        $this->declareQueues($exchangeName, $retryExchangeName, $deadLetterExchangeName, ...$subscribers);
    }

    // Declaring an exchange in a try-catch block for robust error handling
    private function declareExchange(string $exchangeName): void
    {
        $exchange = $this->connection->exchange($exchangeName);
        $exchange->setType(AMQP_EX_TYPE_TOPIC);
        $exchange->setFlags(AMQP_DURABLE);
        $this->safeDeclare(fn() => $exchange->declareExchange());
    }

    // Refactoring queue declaration for each subscriber

    /**
     * @throws Exception
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

    // Handling queue declarations per subscriber with enhanced readability and error handling

    /**
     * @throws Exception
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

        $this->safeBindQueue($queue, $exchangeName, $queueName);
        $this->safeBindQueue($retryQueue, $retryExchangeName, $queueName);
        $this->safeBindQueue($deadLetterQueue, $deadLetterExchangeName, $queueName);

        foreach ($subscriber::subscribedTo() as $eventClass) {
            $this->safeBindQueue($queue, $exchangeName, $eventClass::eventName());
        }
    }

    // Queue declaration with error handling for robustness
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
        $this->safeDeclare(fn() => $queue->declareQueue());

        return $queue;
    }

    // Centralized error handling for declaring exchanges and queues
    private function safeDeclare(callable $declareCallable): void
    {
        try {
            $declareCallable();
        } catch (AMQPChannelException|AMQPConnectionException|AMQPExchangeException) {
            //TODO catch
        }
    }

    // Centralized error handling for binding queues
    private function safeBindQueue(AMQPQueue $queue, string $exchangeName, string $routingKey): void
    {
        try {
            $queue->bind($exchangeName, $routingKey);
        } catch (AMQPChannelException|AMQPConnectionException) {
            //TODO catch
        }
    }
}
