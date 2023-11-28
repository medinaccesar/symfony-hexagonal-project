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
    const string INTERNAL = 'internal_error';
    const string VALIDATION = 'validation_error';
    const string NOT_FOUND = 'not_found';
    const string DUPLICATE = 'duplicate';
    const string NOT_SUPPORTED = 'not_supported';

}
