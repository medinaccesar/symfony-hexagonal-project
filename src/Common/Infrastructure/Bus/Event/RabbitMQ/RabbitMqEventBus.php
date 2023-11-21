<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ;

use AMQPException;
use Common\Domain\Bus\Event\DomainEvent;
use Common\Domain\Bus\Event\EventBusInterface;

/**
 * RabbitMQ implementation of an event bus.
 */
final class RabbitMqEventBus implements EventBusInterface
{
    private RabbitMqConnection $connection;
    private string $exchangeName;
    private MySqlDoctrineEventBus $failoverPublisher;

    /**
     * Constructor for RabbitMqEventBus.
     *
     * @param RabbitMqConnection $connection Connection instance for RabbitMQ.
     * @param string $exchangeName Name of the main exchange.
     * @param MySqlDoctrineEventBus $failoverPublisher Failover event publisher.
     */
    public function __construct(
        RabbitMqConnection $connection,
        string $exchangeName,
        MySqlDoctrineEventBus $failoverPublisher
    ) {
        $this->connection = $connection;
        $this->exchangeName = $exchangeName;
        $this->failoverPublisher = $failoverPublisher;
    }

    /**
     * Publishes domain events to the RabbitMQ exchange.
     *
     * @param DomainEvent ...$events Domain events to publish.
     */
    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->publishEvent($event);
        }
    }

    /**
     * Publishes a single domain event, with failover handling.
     *
     * @param DomainEvent $event The domain event to publish.
     */
    private function publishEvent(DomainEvent $event): void
    {
        try {
            // Publish logic here, similar to your original implementation.
        } catch (AMQPException $exception) {
            $this->failoverPublisher->publish($event);
        }
    }

    // Additional private methods if needed.
}
