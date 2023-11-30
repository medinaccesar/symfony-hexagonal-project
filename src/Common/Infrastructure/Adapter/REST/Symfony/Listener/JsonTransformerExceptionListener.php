<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Listener;

use Common\Domain\Exception\Constant\ExceptionMessage;
use Common\Domain\Exception\Constant\ExceptionType;
use Common\Domain\Exception\ValidationException;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class JsonTransformerExceptionListener
{
    /**
     * This method is called when an exception occurs in the kernel.
     *
     * @param ExceptionEvent $event the event object containing the exception and request details
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        dd($exception);
        $response = $this->createJsonResponse($exception, $event->getRequest());
        $event->setResponse($response);
    }

    /**
     * Creates a JSON response based on the exception and the request.
     *
     * @param \Throwable $exception the caught exception
     * @param Request    $request   the current request
     *
     * @return JsonApiResponse the JSON response to be returned
     */
    private function createJsonResponse(\Throwable $exception, Request $request): JsonApiResponse
    {
        $errorData = $this->getErrorData($exception);

        $rawStatusCode = $exception->getCode() ?: (method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500);
        $statusCode = is_int($rawStatusCode) ? $rawStatusCode : 500;

        $message = $this->getErrorMessage($exception, $statusCode);

        return new JsonApiResponse(
            $errorData,
            $statusCode,
            $message,
            $this->getErrorType($exception),
            true
        );
    }

    /**
     * Retrieves error data from the exception if applicable.
     *
     * @param \Throwable $exception the caught exception
     *
     * @return mixed error data or null
     */
    private function getErrorData(\Throwable $exception): mixed
    {
        return $exception instanceof ValidationException ? $exception->getViolations() : null;
    }

    /**
     * Generates an appropriate error message or throws a ValidationException.
     *
     * @param \Throwable $exception  the caught exception
     * @param int        $statusCode the HTTP status code
     *
     * @return string the error message
     */
    private function getErrorMessage(\Throwable $exception, int $statusCode): string
    {
        if (500 === $statusCode) {
            return ExceptionMessage::INTERNAL;
        }

        return $exception->getMessage();
    }

    /**
     * Determines the type of error based on the exception.
     *
     * @param \Throwable $exception the caught exception
     *
     * @return string the error type
     */
    private function getErrorType(\Throwable $exception): string
    {
        return method_exists($exception, 'getType') ? $exception->getType() : ExceptionType::EXCEPTION;
    }
}
