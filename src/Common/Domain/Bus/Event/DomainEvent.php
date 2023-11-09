<?php

namespace Common\Domain\Bus\Event;

use Exception;

readonly abstract class DomainEvent
{
    private string $eventId;
    private string $occurredOn;

    /**
     * @throws Exception
     */
    public function __construct(private string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->eventId = $eventId ?? bin2hex(random_bytes(16));
        $this->occurredOn = $occurredOn ?? date('c');
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array  $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    final public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    final public function eventId(): string
    {
        return $this->eventId;
    }

    final public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}