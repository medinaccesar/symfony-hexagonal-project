<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ;

use AMQPException;
use Common\Domain\Bus\Event\DomainEvent;
use Common\Domain\Bus\Event\EventBusInterface;
use Common\Infrastructure\Bus\Event\DomainEventJsonSerializer;
use Common\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBus;

/**
 * RabbitMQ's implementation of an event bus.
 * This class is responsible for publishing domain events to a RabbitMQ exchange.
 */
final readonly class RabbitMqEventBus implements EventBusInterface
{
    /**
     * Constructor for RabbitMqEventBus.
     * Initializes the connection to RabbitMQ, the exchange name, and the fail over publisher.
     *
     * @param RabbitMqConnection    $connection        connection instance for RabbitMQ
     * @param string                $exchangeName      name of the main exchange
     * @param MySqlDoctrineEventBus $failoverPublisher fail over event publisher
     */
    public function __construct(
        private RabbitMqConnection $connection,
        private string $exchangeName,
        private MySqlDoctrineEventBus $failoverPublisher
    ) {
    }

    /**
     * Publishes domain events to the RabbitMQ exchange.
     * If publishing fails, it falls back to a fail over publisher.
     *
     * @param DomainEvent ...$events Domain events to publish.
     *
     * @throws \Exception if an error occurs during publishing
     */
    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->publishEvent($event);
        }
    }

    /**
     * Publishes a single domain event, with fail over handling.
     * It serializes the event and publishes it to the specified exchange.
     * In case of an AMQPException, it delegates to the fail over publisher.
     *
     * @param DomainEvent $event the domain event to publish
     *
     * @throws \Exception if an error occurs during publishing
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
        } catch (\AMQPException) {
            $this->failoverPublisher->publish($event);
        }
    }
}
