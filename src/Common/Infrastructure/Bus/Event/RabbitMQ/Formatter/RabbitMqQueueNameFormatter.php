<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ\Formatter;

use Common\Domain\Bus\Event\DomainEventSubscriberInterface;
use Common\Domain\Utils\Trait\StringUtil;

/**
 * Formatter for generating RabbitMQ queue names based on event subscriber classes.
 * This class provides methods to format queue names for RabbitMQ, including variations like retry and dead letter queues,
 * based on the class names of domain event subscribers.
 */
readonly final class RabbitMqQueueNameFormatter
{
    use StringUtil;

    /**
     * Formats a queue name based on the event subscriber class.
     * The format uses the namespace and class name of the subscriber, transforming them into a snake_case representation.
     *
     * @param DomainEventSubscriberInterface $subscriber The event subscriber instance.
     * @return string The formatted queue name.
     */
    public static function format(DomainEventSubscriberInterface $subscriber): string
    {
        $subscriberClassPaths = explode('\\', $subscriber::class);
        $queueNameParts = [
            $subscriberClassPaths[0],
            $subscriberClassPaths[1],
            $subscriberClassPaths[2],
            end($subscriberClassPaths),
        ];

        return implode('.', array_map([self::class, 'transformToSnakeCase'], $queueNameParts));
    }

    /**
     * Formats a retry queue name for a given event subscriber.
     *
     * @param DomainEventSubscriberInterface $subscriber The event subscriber instance.
     * @return string The formatted retry queue name.
     */
    public static function formatRetry(DomainEventSubscriberInterface $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "retry.$queueName";
    }

    /**
     * Formats a dead letter queue name for a given event subscriber.
     *
     * @param DomainEventSubscriberInterface $subscriber The event subscriber instance.
     * @return string The formatted dead letter queue name.
     */
    public static function formatDeadLetter(DomainEventSubscriberInterface $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "dead_letter.$queueName";
    }

    /**
     * Formats a short queue name based on the class name of the subscriber.
     * Only uses the class name of the subscriber, transforming it into a snake_case representation.
     *
     * @param DomainEventSubscriberInterface $subscriber The event subscriber instance.
     * @return string The short formatted queue name.
     */
    public static function shortFormat(DomainEventSubscriberInterface $subscriber): string
    {
        $subscriberClassParts = explode('\\', $subscriber::class);
        $subscriberCamelCaseName = end($subscriberClassParts);

        return self::toSnakeCase($subscriberCamelCaseName);
    }

    /**
     * Transforms a given text to snake_case.
     *
     * @param string $text The text to transform.
     * @return string The transformed text in snake_case.
     */
    private static function transformToSnakeCase(string $text): string
    {
        return self::toSnakeCase($text);
    }
}
