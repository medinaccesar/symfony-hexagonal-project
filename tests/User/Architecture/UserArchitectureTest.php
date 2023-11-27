<?php

namespace Tests\User\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;
use Tests\Api\Architecture\ConfigArchitectureTest;

final class UserArchitectureTest
{
    public static function testDomainRules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('User\Domain'))
            ->canOnlyDependOn()
            ->classes(...array_merge(ConfigArchitectureTest::languageClasses(), [
                Selector::inNamespace('User\Domain'),
                Selector::inNamespace('Common\Domain'),
            ]))
            ->because('User domain can only import itself');
    }

    public static function testApplicationRules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('User\Application'))
            ->canOnlyDependOn()
            ->classes(...array_merge(ConfigArchitectureTest::languageClasses(), [
                Selector::inNamespace('User\Application'),
                Selector::inNamespace('User\Domain'),
                Selector::inNamespace('Common\Domain'),
            ]))
            ->because('User application can only import itself and Common');
    }


    public static function testInfrastructureRules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('User\Infrastructure'))
            ->shouldNotDependOn()
            ->classes(Selector::inNamespace('User'))
            ->excluding(
                Selector::inNamespace('User'),
                Selector::inNamespace('Common'),
            )
            ->because('User infrastructure can only import module User and Common');
    }
}