<?php

namespace Common\Infrastructure\Bus\Event;

use Common\Domain\Bus\Event\DomainEventSubscriberInterface;
use RuntimeException;

/**
 * Manages the mapping between domain event names and their corresponding subscriber classes.
 */
final class DomainEventMapping
{
    private array $mapping;

    /**
     * Initializes the mapping from an iterable set of DomainEventSubscribers.
     * The mapping is created by associating domain event names with the corresponding subscriber class.
     *
     * @param iterable $mapping An iterable of DomainEventSubscribers.
     */
    public function __construct(iterable $mapping)
    {
        $this->mapping = array_reduce(
            (array)$mapping,
            fn (array $carry, DomainEventSubscriberInterface $subscriber) =>
            [...$carry, ...$this->mapSubscribersToEventNames($subscriber)],
            []
        );
    }

    /**
     * Maps a DomainEventSubscriber to its event names.
     *
     * @param DomainEventSubscriberInterface $subscriber The event subscriber.
     * @return array The mapping of event names to the subscriber class.
     */
    private function mapSubscribersToEventNames(DomainEventSubscriberInterface $subscriber): array
    {
        $eventClasses = $subscriber::subscribedTo();
        $subscriberClass = get_class($subscriber);

        return array_combine(
            array_map(fn (string $eventClass) => $eventClass::eventName(), $eventClasses),
            array_fill(0, count($eventClasses), $subscriberClass)
        );
    }

    /**
     * Retrieves the corresponding DomainEventSubscriber class for a given event name.
     *
     * @param string $name The event name.
     * @return string The DomainEventSubscriber class name.
     * @throws RuntimeException If no subscriber is found for the given name.
     */
    public function for(string $name): string
    {
        if (!isset($this->mapping[$name])) {
            throw new RuntimeException("The Domain Event Class for <$name> doesn't exist or has no subscribers");
        }

        return $this->mapping[$name];
    }
}
