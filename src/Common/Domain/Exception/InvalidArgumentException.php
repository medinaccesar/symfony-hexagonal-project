<?php
declare(strict_types=1);

namespace Common\Domain\Exception;

use InvalidArgumentException as NativeInvalidArgumentException;
use function sprintf;

class InvalidArgumentException extends NativeInvalidArgumentException
{
    const INVALID_ARGUMENT_EXCEPTION = 400;

    public static function createFromMessage(string $message): self
    {
        return new static($message, self::INVALID_ARGUMENT_EXCEPTION);
    }

    public static function createFromArgument(string $argument): self
    {
        return new static(sprintf('Invalid argument [%s]', $argument), self::INVALID_ARGUMENT_EXCEPTION);
    }

    public static function createFromArray(array $arguments): self
    {
        return new static(sprintf('Invalid arguments [%s]', \implode(', ', $arguments)), self::INVALID_ARGUMENT_EXCEPTION);
    }

}
