<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Transformer;

use Common\Domain\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function in_array;
use const JSON_THROW_ON_ERROR;

class RequestTransformer
{
    private const ALLOWED_CONTENT_TYPE = 'application/json';
    private const SUPPORTED_METHODS = [Request::METHOD_GET, Request::METHOD_POST, Request::METHOD_PUT, Request::METHOD_PATCH];

    public function transform(Request $request): void
    {
        $contentType = $request->headers->get('Content-Type');
        if ($contentType !== self::ALLOWED_CONTENT_TYPE) {
            throw new InvalidArgumentException(sprintf('[%s] is the only Content-Type allowed', self::ALLOWED_CONTENT_TYPE), Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }

        $method = $request->getMethod();
        if (!in_array($method, self::SUPPORTED_METHODS, true)) {
            throw new InvalidArgumentException('REST method not supported', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($method === Request::METHOD_POST || $method === Request::METHOD_PUT || $method === Request::METHOD_PATCH) {
            try {
                $content = $request->getContent();
                $jsonData = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new InvalidArgumentException('Invalid JSON payload', Response::HTTP_BAD_REQUEST);
                }
                $request->request->replace($jsonData);
            } catch (\JsonException) {
                throw new InvalidArgumentException('Invalid JSON payload', Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
