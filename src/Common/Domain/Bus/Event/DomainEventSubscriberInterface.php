<?php

declare(strict_types=1);

namespace Common\Domain\Bus\Event;

/**
 * Interface for a domain event subscriber.
 *
 * This interface defines the contract for subscribers that listen to domain events.
 * Implementers of this interface should provide the logic to handle specific types of domain events.
 */
interface DomainEventSubscriberInterface
{
    /**
     * Specifies the domain events that the subscriber is interested in.
     * This method should return an array of domain event class names that the subscriber wants to handle.
     * The event bus uses this information to route the appropriate events to the subscriber.
     *
     * @return string[] An array of domain event class names.
     */
    public static function subscribedTo(): array;
}
