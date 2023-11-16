<?php

namespace Common\Domain\Exception\Interface;


/**
 * Interface ViolationExceptionInterface
 *
 * This interface should be implemented by exceptions that need to return detailed
 * violation information in a standardized format. It ensures consistency across
 * different types of exceptions that report validation errors or other violations.
 *
 * The getViolations method should return an array of arrays, each containing
 * 'field' and 'message' keys to describe the violation.
 */
interface ViolationExceptionInterface
{
    /**
     * Gets an array of standardized violation entries.
     *
     * Each violation entry is an associative array with the following keys:
     * - 'field': The field or property that the violation pertains to.
     * - 'message': A descriptive message about the violation.
     *
     * @return array An array of associative arrays, each representing a violation.
     */
    public function getViolations(): array;
}