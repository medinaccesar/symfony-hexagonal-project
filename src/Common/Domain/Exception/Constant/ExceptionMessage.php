<?php

declare(strict_types=1);

namespace Common\Domain\Exception\Constant;

/**
 * ExceptionMessage class to hold constant messages for various exceptions.
 *
 * This class provides a centralized location for defining standard messages
 * associated with different types of exceptions. Using these constants ensures
 * consistency across the application when handling and reporting errors.
 */
class ExceptionMessage
{
    const INTERNAL = 'internal_error';
    const VALIDATION = 'validation_error';
    const NOT_FOUND = 'not_found';
    const DUPLICATE = 'duplicate';
    const NOT_SUPPORTED = 'not_supported';

}
