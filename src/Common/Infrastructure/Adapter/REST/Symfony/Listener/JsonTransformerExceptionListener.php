<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Listener;

use Common\Domain\Exception\ValidationException;
use Common\Domain\Exception\ResourceNotFoundException;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

#[When(env: 'prod')]
class JsonTransformerExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        $data = null;
        $status = $this->getStatusCode($e);
        $message = $e->getMessage();
        $errors = [];

        if ($e instanceof ValidationException) {
            $errors = $e->getViolations();
        }

        if (!empty($errors)) {
            $data = $errors;
        }

        $response = new JsonApiResponse($data, $message, $status);
        $event->setResponse($response);
    }

    private function getStatusCode(Throwable $e): int
    {
        return match (true) {
            $e instanceof ResourceNotFoundException => Response::HTTP_NOT_FOUND,
            $e instanceof InvalidArgumentException => Response::HTTP_BAD_REQUEST,
            $e instanceof ValidationException => Response::HTTP_UNPROCESSABLE_ENTITY,
            default => Response::HTTP_INTERNAL_SERVER_ERROR
        };
    }
}
