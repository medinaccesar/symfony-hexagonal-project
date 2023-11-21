<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ;

use AMQPException;
use Common\Domain\Bus\Event\DomainEvent;
use Common\Domain\Bus\Event\EventBusInterface;
use Common\Infrastructure\Bus\Event\DomainEventJsonSerializer;
use Common\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBus;
use Exception;

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
     * @throws Exception
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
     * @throws Exception
     */
    private function publishEvent(DomainEvent $event): void
    {
        try {
            $body = DomainEventJsonSerializer::serialize($event);
            $routingKey = $event::eventName();
            $messageId = $event->eventId();

            $this->connection->exchange($this->exchangeName)->publish(
                $body,
                $routingKey,
                AMQP_NOPARAM,
                [
                    'message_id' => $messageId,
                    'content_type' => 'application/json',
                    'content_encoding' => 'utf-8',
                ]
            );
        } catch (AMQPException) {
            $this->failoverPublisher->publish($event);
        }
    }

    // Additional private methods if needed.
}
