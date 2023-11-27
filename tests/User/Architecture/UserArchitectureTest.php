<?php

namespace Tests\User\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;
use Tests\Api\Architecture\ConfigArchitectureTest;

final class UserArchitectureTest
{
    /**
     * The Domain layer can ONLY communicate with itself or with the Common\Domain layer
     * @return Rule
     */
    public static function testDomainRules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('User\Domain'))
            ->canOnlyDependOn()
            ->classes(...array_merge(ConfigArchitectureTest::languageClasses(), [
                Selector::inNamespace('User\Domain'),
                Selector::inNamespace('Common\Domain'),
            ]))
            ->because(ConfigArchitectureTest::DOMAIN_ERROR_MESSAGE);
    }

    /**
     * The Application layer can "known" or communicate ONLY with the Domain layer
     * @return Rule
     */
    public static function testApplicationRules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('User\Application'))
            ->canOnlyDependOn()
            ->classes(...array_merge(ConfigArchitectureTest::languageClasses(), [
                Selector::inNamespace('User\Application'),
                Selector::inNamespace('User\Domain'),

                Selector::inNamespace('Common\Domain')
            ]))
            ->because(ConfigArchitectureTest::APPLICATION_ERROR_MESSAGE);
    }

    /**
     * The Infrastructure layer can "know" or communicate with the Application and Domain layers
     * @return Rule
     */
    public static function testInfrastructureRules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('User\Infrastructure'))
            ->canOnlyDependOn()
            ->classes(
                Selector::inNamespace('User'),
                Selector::inNamespace('Common\Domain'),
                Selector::inNamespace('Common\Infrastructure'),

                Selector::inNamespace('Symfony'),
                Selector::inNamespace('Doctrine')
            )
            ->because(ConfigArchitectureTest::INFRASTRUCTURE_ERROR_MESSAGE);
    }
}