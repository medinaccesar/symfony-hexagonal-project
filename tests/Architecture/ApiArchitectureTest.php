<?php

namespace Tests\Architecture;

use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Exception;
use InvalidArgumentException;
use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;
use RuntimeException;
use Throwable;

class ApiArchitectureTest
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
    public function testDomainLayerArchitecture(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('.*\\\\Domain$', true))
            ->canOnlyDependOn()
            ->classes(Selector::inNamespace('Common\Domain', true),
            (Selector::inNamespace('.*\\\\Domain$', true))
            )
            ->because('Domain layer should only depend on its own or common domain layers');
    }

    public function testApplicationLayerArchitecture(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('.*\\\\Application$', true))
            ->canOnlyDependOn()
            ->classes(Selector::inNamespace('.*\\\\Domain$', true))
            ->because('Application layer should only depend on domain layers');
    }
}