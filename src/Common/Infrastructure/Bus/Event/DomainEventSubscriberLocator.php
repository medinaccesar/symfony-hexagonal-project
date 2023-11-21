<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event;

use Common\Domain\Bus\Event\DomainEventSubscriberInterface;
use Common\Infrastructure\Bus\CallableFirstParameterExtractor;
use Common\Infrastructure\Bus\Event\RabbitMQ\Formatter\RabbitMqQueueNameFormatter;
use RuntimeException;
use Traversable;

/**
 * Locator for domain event subscribers.
 * This class is responsible for locating event subscribers based on various criteria such as event types or queue names.
 * It uses a provided mapping of subscribers to identify the relevant subscribers for given conditions.
 */
readonly final class DomainEventSubscriberLocator
{
    private array $mapping;

    /**
     * @param Traversable $mapping The iterable mapping of event subscribers.
     */
    public function __construct(Traversable $mapping)
    {
        // Convert the Traversable mapping to an array for internal use.
        $this->mapping = iterator_to_array($mapping);
    }

    /**
     * Retrieves all subscribers subscribed to a specific event class.
     *
     * @param string $eventClass The class name of the event.
     * @return array An array of subscribers for the specified event class.
     */
    public function allSubscribedTo(string $eventClass): array
    {
        $subscribers = CallableFirstParameterExtractor::forCallables($this->mapping);
        return $subscribers[$eventClass] ?? [];
    }

    /**
     * Retrieves a subscriber by a specific RabbitMQ queue name.
     *
     * @param string $queueName The name of the RabbitMQ queue.
     * @return DomainEventSubscriberInterface The subscriber associated with the given queue name.
     * @throws RuntimeException If no subscriber is found for the specified queue name.
     */
    public function withRabbitMqQueueNamed(string $queueName): DomainEventSubscriberInterface
    {
        foreach ($this->mapping as $subscriber) {
            if (RabbitMqQueueNameFormatter::format($subscriber) === $queueName) {
                return $subscriber;
            }
        }
        throw new RuntimeException("No subscribers for the <$queueName> queue");
    }

    /**
     * Retrieves all subscribers.
     *
     * @return array An array of all subscribers.
     */
    public function all(): array
    {
        return $this->mapping;
    }
}
