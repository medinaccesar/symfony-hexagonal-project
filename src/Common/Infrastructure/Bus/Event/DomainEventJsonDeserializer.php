<?php

namespace Common\Infrastructure\Bus\Event;

use Common\Domain\Bus\Event\DomainEvent;
use Common\Infrastructure\Bus\Event\DomainEventMapping;

final readonly class DomainEventJsonDeserializer
{
    public function __construct(private DomainEventMapping $mapping)
    {
    }

    public function deserialize(string $domainEvent): DomainEvent
    {
        $eventData = json_decode($domainEvent, true);
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