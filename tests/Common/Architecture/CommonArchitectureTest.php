<?php

namespace Tests\Common\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;
use Tests\Api\Architecture\ConfigArchitectureTest;

final class CommonArchitectureTest
{
    /**
     * The Domain layer can ONLY communicate with itself or with the Common\Domain layer
     * @return Rule
     */
    public function testDomainRules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('Common\Domain'))
            ->canOnlyDependOn()
            ->classes(...array_merge(ConfigArchitectureTest::languageClasses(), [
                Selector::inNamespace('Common\Domain')
            ]))
            ->because(ConfigArchitectureTest::DOMAIN_ERROR_MESSAGE);
    }

    /**
     * The Application layer can "known" or communicate ONLY with the Common\Domain layer
     * @return Rule
     */
    public static function testApplicationRules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('Common\Application'))
            ->canOnlyDependOn()
            ->classes(...array_merge(ConfigArchitectureTest::languageClasses(), [
                Selector::inNamespace('Common\Application'),
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
            ->classes(Selector::inNamespace('Common\Infrastructure'))
            ->shouldNotDependOn()
            ->classes(
                Selector::inNamespace('User'),
                Selector::inNamespace('Home'),
                //(...) other modules
            )
            ->because(ConfigArchitectureTest::INFRASTRUCTURE_ERROR_MESSAGE);
    }
}