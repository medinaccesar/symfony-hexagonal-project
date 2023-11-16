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

}
