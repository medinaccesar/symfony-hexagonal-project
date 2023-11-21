<?php

namespace Common\Infrastructure\Bus\Event;

use Common\Domain\Bus\Event\DomainEventSubscriberInterface;
use RuntimeException;

final class DomainEventMapping
{
    private array $mapping;

    /**
     * Constructor for DomainEventMapping.
     *
     * @param iterable $mapping An iterable of DomainEventSubscribers.
     */
    public function __construct(iterable $mapping)
    {
        $this->mapping = array_reduce(
            (array)$mapping,
            fn (array $carry, DomainEventSubscriberInterface $subscriber) =>
            [...$carry, ...array_combine(
                array_map(
                    fn (string $eventClass) => $eventClass::eventName(),
                    $subscriber::subscribedTo()
                ),
                array_fill(0, count($subscriber::subscribedTo()), get_class($subscriber))
            )],
            []
        );
    }

    /**
     * Retrieves the corresponding DomainEventSubscriber class for the given event name.
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
