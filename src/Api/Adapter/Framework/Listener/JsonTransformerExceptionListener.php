<?php

declare(strict_types=1);

namespace Api\Adapter\Framework\Listener;

use Core\Exception\ResourceNotFoundException;
use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

//#[When(env: 'prod')]
class JsonTransformerExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        $data = [
            'class' => \get_class($e),
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ];

        if ($e instanceof ResourceNotFoundException) {
            $data['code'] = Response::HTTP_NOT_FOUND;
        }

        if ($e instanceof InvalidArgumentException) {
            $data['code'] = Response::HTTP_BAD_REQUEST;
        }

        $response = new JsonResponse($data, $data['code']);

        $event->setResponse($response);
    }
}
