<?php

namespace Common\Domain\Validation;

class ConstraintTypes
{
    public const DUPLICATE = 'duplicate';
    public const REQUIRED = 'required';
    public const LENGTH = 'length';
    public const FORMAT = 'format';
    public const NOT_BLANK = 'not_blank';
    public const NOT_NULL = 'not_null';
    public const EMAIL = 'email';
    public const RANGE = 'range';
    public const REGEX = 'regex';
    public const UNIQUE = 'unique';
}