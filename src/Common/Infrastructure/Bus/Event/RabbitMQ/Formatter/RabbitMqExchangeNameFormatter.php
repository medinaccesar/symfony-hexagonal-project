<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ\Formatter;

final class RabbitMqExchangeNameFormatter
{
    /**
     * Formats a retry exchange name based on the given exchange name.
     *
     * @param string $exchangeName the original exchange name
     *
     * @return string the formatted retry exchange name
     */
    public static function retry(string $exchangeName): string
    {
        return "retry-$exchangeName";
    }

    /**
     * Formats a dead letter exchange name based on the given exchange name.
     *
     * @param string $exchangeName the original exchange name
     *
     * @return string the formatted dead letter exchange name
     */
    public static function deadLetter(string $exchangeName): string
    {
        return "dead_letter-$exchangeName";
    }
}
