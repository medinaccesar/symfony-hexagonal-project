<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Listener;

use Common\Domain\Exception\DuplicateResourceException;
use Common\Domain\Exception\InvalidArgumentException;
use Common\Domain\Exception\ResourceNotFoundException;
use Common\Domain\Exception\ValidationException;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

#[When(env: 'prod')]
class JsonTransformerExceptionListener
{
    private const EXCEPTION_MAP = [
        ResourceNotFoundException::class,
        InvalidArgumentException::class,
        DuplicateResourceException::class,
        ValidationException::class,
        MethodNotAllowedHttpException::class
        //(...)
    ];

    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();
        [$status, $message] = $this->resolveExceptionDetails($e);
        $errors = $e instanceof ValidationException ? $e->getViolations() : null;
        $dataKey = $errors ? 'violations' : null;

        $response = new JsonApiResponse($errors, $status, $message, true, $dataKey);
        $event->setResponse($response);
    }

    private function resolveExceptionDetails(Throwable $e): array
    {
        $exceptionClass = get_class($e);
        if (in_array($exceptionClass, self::EXCEPTION_MAP)) {
            $status = $e->getCode() !== 0 ? $e->getCode() : $e->getStatusCode();
            $message = $e->getMessage();
            return [$status, $message];
        }
        return [Response::HTTP_INTERNAL_SERVER_ERROR, 'An internal server error occurred.'];
    }
}
