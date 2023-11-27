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
    const DOMAIN_ERROR_MESSAGE = 'The Domain layer can ONLY communicate with itself or with the Common\Domain layer';
    const INFRASTRUCTURE_ERROR_MESSAGE = 'The Infrastructure layer can "know" or communicate with the Application and Domain layers';
    const APPLICATION_ERROR_MESSAGE = 'The Application layer can "known" or communicate ONLY with the Domain layers';

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