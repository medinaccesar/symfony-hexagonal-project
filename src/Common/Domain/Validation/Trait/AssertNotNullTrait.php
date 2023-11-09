<?php

namespace Common\Domain\Validation\Trait;

use Common\Domain\Exception\InvalidArgumentException;
use function array_combine;
use function is_null;

trait AssertNotNullTrait
{
    public function assertNotNull(array $args, array $values): void
    {
        $args = array_combine($args, $values);

        $emptyValues = [];
        foreach ($args as $key => $value) {
            if (is_null($value)) {
                $emptyValues[] = $key;
            }
        }

        if (!empty($emptyValues)) {
            throw InvalidArgumentException::createFromArray($emptyValues);
        }
    }
}
