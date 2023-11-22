<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ\Formatter;

use Common\Domain\Bus\Event\DomainEventSubscriberInterface;
use Common\Domain\Utils\Trait\StringUtil;
use Exception;

/**
 * A formatter class for generating RabbitMQ queue names based on event subscriber classes.
 * This class provides methods to format queue names for RabbitMQ, including standard,
 * retry, and dead letter queues, based on the class names of domain event subscribers.
 */
readonly final class RabbitMqQueueNameFormatter
{
    use StringUtil;

    /**
     * Formats a queue name based on the event subscriber class.
     * The format uses parts of the namespace and class name of the subscriber,
     * transforming them into a snake_case representation.
     *
     * @param DomainEventSubscriberInterface $subscriber The event subscriber instance.
     * @return string The formatted queue name.
     *
     * @throws Exception If the subscriber class name structure is not as expected.
     */
    public static function format(DomainEventSubscriberInterface $subscriber): string
    {
        $subscriberClassPaths = explode('\\', $subscriber::class);

        // Check if the class name has the expected structure.
        if (count($subscriberClassPaths) < 4) {
            // Handle the error or adjust the logic as needed.
            throw new Exception("Unexpected class name structure for subscriber.");
        }

        $queueNameParts = [
            $subscriberClassPaths[0],
            $subscriberClassPaths[1],
            $subscriberClassPaths[2],
            end($subscriberClassPaths),
        ];

        return implode('.', array_map(fn($part) => self::toSnakeCase($part), $queueNameParts));
    }

    /**
     * Formats a short queue name based solely on the class name of the subscriber.
     * The class name is transformed into a snake_case representation.
     *
     * @param DomainEventSubscriberInterface $subscriber The event subscriber instance.
     * @return string The short formatted queue name.
     */
    public static function shortFormat(DomainEventSubscriberInterface $subscriber): string
    {
        $arraySubscriber = explode('\\', $subscriber::class);
        $subscriberCamelCaseName = end($arraySubscriber);
        return self::toSnakeCase($subscriberCamelCaseName);
    }

    /**
     * @throws Exception
     */
    public static function formatRetry(DomainEventSubscriberInterface $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "retry.$queueName";
    }

    /**
     * @throws Exception
     */
    public static function formatDeadLetter(DomainEventSubscriberInterface $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "dead_letter.$queueName";
    }


}
