<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Listener;

use Common\Domain\Exception\DuplicateValidationResourceException;
use Common\Domain\Exception\Interface\ViolationExceptionInterface;
use Common\Domain\Exception\InvalidArgumentException;
use Common\Domain\Exception\ResourceNotFoundException;
use Common\Domain\Exception\ValidationException;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

/**
 * Listener to transform exceptions into structured JSON responses.
 * It handles specific exceptions listed in EXCEPTION_MAP to provide
 * appropriate error information without treating them as internal server errors.
 */
#[When(env: 'prod')]
class JsonTransformerExceptionListener
{
    private const EXCEPTION_MAP = [
        ResourceNotFoundException::class,
        InvalidArgumentException::class,
        DuplicateValidationResourceException::class,
        ValidationException::class,
        MethodNotAllowedHttpException::class
        // Add other exceptions as needed...
    ];

    /**
     * Handles the kernel exception event and sets a structured JSON response.
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        [$status, $class] = $this->resolveExceptionDetails($e);
        $message = $e->getMessage();
        $violations = $e instanceof ViolationExceptionInterface ? $e->getViolations() : null;

        // Create a structured JSON response for the exception
        $response = new JsonApiResponse($violations, $status, $message, true, $class);
        $event->setResponse($response);
    }

    /**
     * Resolves the HTTP status and class name for the given exception.
     * Returns internal server error for unhandled exceptions.
     */
    private function resolveExceptionDetails(Throwable $e): array
    {
        $exceptionClass = get_class($e);

        // Check if the exception is within the controlled exception list
        if (in_array($exceptionClass, self::EXCEPTION_MAP)) {
            $status = $e->getCode() !== 0 ? $e->getCode() : $e->getStatusCode();
            $class = basename(str_replace('\\', '/', $exceptionClass));
            return [$status, $class];
        }

        // Default response for unhandled exceptions
        return [Response::HTTP_INTERNAL_SERVER_ERROR, 'An internal server error occurred.'];
    }
}

