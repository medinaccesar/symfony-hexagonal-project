<?php

namespace Tests\Api\Architecture;

use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Exception;
use InvalidArgumentException;
use PHPat\Selector\Selector;
use RuntimeException;
use Throwable;

class ConfigArchitectureTest
{
    public static function languageClasses(): array
    {
        return [
            Selector::classname(Throwable::class),
            Selector::classname(Exception::class),
            Selector::classname(InvalidArgumentException::class),
            Selector::classname(RuntimeException::class),
            Selector::classname(DateTimeImmutable::class),
            Selector::classname(DateTimeInterface::class),
            Selector::classname(DomainException::class),
        ];
    }
}