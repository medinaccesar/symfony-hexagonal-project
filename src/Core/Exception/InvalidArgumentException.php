<?php
declare(strict_types=1);

namespace Core\Exception;

use InvalidArgumentException as NativeInvalidArgumentException;
use function sprintf;

class InvalidArgumentException extends NativeInvalidArgumentException
{
    public static function createFromMessage(string $message): self
    {
        return new static($message);
    }

    public static function createFromArgument(string $argument): self
    {
        return new static(sprintf('Invalid argument [%s]', $argument));
    }

    public static function createFromArray(array $arguments): self
    {
        return new static(sprintf('Invalid arguments [%s]', \implode(', ', $arguments)));
    }

    public static function createFromMinAndMaxLength(int $min, int $max): self
    {
        return new static(sprintf('Value must be min [%d] and max [%d] characters', $min, $max));
    }
}
