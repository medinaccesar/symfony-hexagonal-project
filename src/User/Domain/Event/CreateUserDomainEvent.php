<?php

declare(strict_types=1);

namespace User\Domain\Event;

use Common\Domain\Bus\Event\DomainEvent;

/**
 * Domain event for when a user is created.
 *
 * This class extends the DomainEvent class, providing specifics for the user creation event.
 * It encapsulates all the necessary data and behaviors related to this event.
 */
readonly class CreateUserDomainEvent extends DomainEvent
{

    /**
     * Constructor for CreateUserDomainEvent.
     *
     * @param string $id The unique identifier for the event.
     * @param string $username The username associated with the event.
     * @param string|null $eventId The event ID, if any.
     * @param string|null $occurredOn The timestamp when the event occurred.
     */
    public function __construct(
        string         $id,
        private string $username,
        ?string        $eventId = null,
        ?string        $occurredOn = null
    )
    {
        parent::__construct($id, $eventId, $occurredOn);
    }

    /**
     * Returns the event name.
     *
     * @return string The name of the event.
     */
    public static function eventName(): string
    {
        return 'user.create';
    }

    /**
     * Factory method to create an instance from primitives.
     *
     * @param string $aggregateId The aggregate identifier.
     * @param array $body The body of the event containing additional data.
     * @param string $eventId The event ID.
     * @param string $occurredOn The timestamp when the event occurred.
     *
     * @return static The created domain event instance.
     */
    public static function fromPrimitives(
        string $aggregateId,
        array  $body,
        string $eventId,
        string $occurredOn
    ): static
    {
        return new self($aggregateId, $body['username'], $eventId, $occurredOn);
    }

    /**
     * Serializes the event data to an array.
     *
     * @return array The serialized event data.
     */
    public function toPrimitives(): array
    {
        return [
            'username' => $this->username
        ];
    }

    /**
     * Gets the username associated with the event.
     *
     * @return string The username.
     */
    public function username(): string
    {
        return $this->username;
    }
}
