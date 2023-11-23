<?php

namespace Common\Infrastructure\Bus\Event;

use Common\Domain\Bus\Event\DomainEvent;
use Common\Infrastructure\Bus\Event\DomainEventMapping;
use JsonException;

/**
 * Responsible for deserializing domain event data from JSON to DomainEvent objects.
 */
final readonly class DomainEventJsonDeserializer
{
    /**
     * Initializes the deserializer with a mapping of event names to their corresponding classes.
     * @param DomainEventMapping $mapping The mapping of event names to domain event classes.
     */
    public function __construct(private DomainEventMapping $mapping) {}

    /**
     * Deserializes a JSON string into a DomainEvent object.
     *
     * @param string $domainEvent The JSON string representing the domain event.
     * @return DomainEvent The deserialized domain event.
     * @throws JsonException If the JSON cannot be decoded or if the decoded data is not in the expected format.
     */
    public function deserialize(string $domainEvent): DomainEvent
    {
        dd($domainEvent);
        $eventData = json_decode($domainEvent, true, 512, JSON_THROW_ON_ERROR);
        $eventName = $eventData['data']['type'];
        $eventClass = $this->mapping->for($eventName);

        return $eventClass::fromPrimitives(
            $eventData['data']['attributes']['id'],
            $eventData['data']['attributes'],
            $eventData['data']['id'],
            $eventData['data']['occurred_on']
        );
    }
}
