<?php

namespace Tests\Common\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;
use Tests\Architecture\ConfigArchitectureTest;

final class CommonArchitectureTest
{
    public function testDomainRules(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('Common\Domain'))
            ->canOnlyDependOn()
            ->classes(...array_merge(ConfigArchitectureTest::languageClasses(), [
                Selector::inNamespace('Common\Domain')
            ]))
            ->because('Common domain can only import itself');
    }
}