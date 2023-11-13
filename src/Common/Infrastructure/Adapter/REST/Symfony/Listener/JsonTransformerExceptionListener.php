<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Listener;

use Common\Domain\Exception\DuplicateResourceException;
use Common\Domain\Exception\ValidationException;
use Common\Domain\Exception\ResourceNotFoundException;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

/**
 * Listener to transform exceptions into JSON API responses.
 *
 * @When(env: 'prod')
 */
class JsonTransformerExceptionListener
{
    const REQUEST_ERROR_MESSAGE = 'A request error occurred.';
    const INTERNAL_ERROR_MESSAGE = 'An internal server error occurred.';

    /**
     * Handles kernel exceptions and transforms them into JSON responses.
     *
     * @param ExceptionEvent $event The event object containing the exception.
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if ($this->isCustomException($e)) {
            $message = $e->getMessage();
            $status = $e->getCode();
        } else {
            $status = $this->getStandardStatusCode($e);
            $message = $this->getStandardErrorMessage($e);
        }

        $errors = $e instanceof ValidationException ? $e->getViolations() : [];
        $data = !empty($errors) ? $errors : null;

        $response = new JsonApiResponse($data, $status, $message, true);
        $event->setResponse($response);
    }

    /**
     * Checks if the thrown exception is a custom defined exception.
     *
     * @param Throwable $e The thrown exception.
     * @return bool True if it's a custom exception, false otherwise.
     */
    private function isCustomException(Throwable $e): bool
    {
        return $e instanceof DuplicateResourceException || $e instanceof ResourceNotFoundException;
    }


    /**
     * Returns the standard status code for non-custom exceptions.
     *
     * @param Throwable $e The thrown exception.
     * @return int The HTTP status code.
     */
    private function getStandardStatusCode(Throwable $e): int
    {
        return match (true) {
            $e instanceof InvalidArgumentException,
                $e instanceof UniqueConstraintViolationException => Response::HTTP_BAD_REQUEST,
            $e instanceof ValidationException => Response::HTTP_UNPROCESSABLE_ENTITY,
            default => Response::HTTP_INTERNAL_SERVER_ERROR,
        };
    }

    /**
     * Returns the standard error message for non-custom exceptions.
     *
     * @param Throwable $e The thrown exception.
     * @return string The error message.
     */
    private function getStandardErrorMessage(Throwable $e): string
    {
        return match (true) {
            $e instanceof ValidationException,
                $e instanceof InvalidArgumentException,
                $e instanceof UniqueConstraintViolationException => self::REQUEST_ERROR_MESSAGE,
            default => self::INTERNAL_ERROR_MESSAGE,
        };
    }
}
