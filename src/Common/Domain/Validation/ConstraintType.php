<?php

declare(strict_types=1);

namespace Common\Domain\Validation;

/**
 * Class containing constants for various types of validation constraints.
 * These constants are used to specify the type of constraint being applied in validation error messages.
 */
class ConstraintType
{
    public const REQUIRED = 'required';
    public const LENGTH = 'length';
    public const FORMAT = 'format';
    public const NOT_BLANK = 'not_blank';
    public const NOT_NULL = 'not_null';
    public const RANGE = 'range';
    public const ROLE = 'invalid_role';
}
