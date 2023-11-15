<?php

namespace Common\Infrastructure\Service\Symfony\Validation;

use Common\Domain\Exception\ValidationException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


readonly class SymfonyValidationService
{

    public function __construct(
        private ValidatorInterface $validator)
    {
    }

    /**
     * Validate the given object.
     *
     * @param mixed $object The object to be validated.
     * @return ConstraintViolationListInterface The list of constraint violations.
     */
    public function validate(mixed $object): ConstraintViolationListInterface
    {
        return $this->validator->validate($object);
    }

    /**
     * Format the given constraint violations into an associative array.
     *
     * @param ConstraintViolationListInterface $violations The list of constraint violations.
     * @return array The formatted array of errors.
     */
    public function formatViolations(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }
        return $errors;
    }

    /**
     * Validate the given object and throw a ValidationException if validation fails.
     *
     * @param mixed $object The object to be validated.
     * @throws ValidationException If validation fails.
     */
    public function validateAndThrows(mixed $object): void
    {
        $violations = $this->validate($object);

        if (count($violations) > 0) {
            throw new ValidationException($this->formatViolations($violations));
        }
    }
}
