<?php

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

class ApiArchitectureTest
{
    public function testUseCaseCanOnlyHaveOnePublicMethod(): Rule
    {
        return PHPat::rule()
            ->classes(
                Selector::classname('/^.+\\\\Application\\\\.+\\\\.+\\\\(?!.*(?:Command|Query|Response)$).*$/', true)
            )
            ->shouldHaveOnlyOnePublicMethod();
    }
}