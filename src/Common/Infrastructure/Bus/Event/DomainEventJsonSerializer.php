<?php

namespace Common\Infrastructure\Bus\Event;

use Common\Domain\Bus\Event\DomainEvent;
use JsonException;

/**
 * Responsible for serializing DomainEvent objects into JSON strings.
 */
final class DomainEventJsonSerializer
{
    /**
     * Serializes a DomainEvent into a JSON string.
     * This method includes key event details like ID, type, occurred date, and other attributes.
     *
     * @param DomainEvent $domainEvent The domain event to serialize.
     * @return string The serialized JSON string of the domain event.
     * @throws JsonException If the serialization fails.
     */
    public static function serialize(DomainEvent $domainEvent): string
    {
        $jsonData = [
            'data' => [
                'id' => $domainEvent->eventId(),
                'type' => $domainEvent::eventName(),
                'occurred_on' => $domainEvent->occurredOn(),
                'attributes' => array_merge($domainEvent->toPrimitives(), ['id' => $domainEvent->aggregateId()]),
            ],
            'meta' => [],
        ];

        return json_encode($jsonData, JSON_THROW_ON_ERROR);
    }
}
