<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Transformer;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use function in_array;


class RequestTransformer
{
    private const ALLOWED_CONTENT_TYPE = 'application/json';
    private const SUPPORTED_METHODS = [
        Request::METHOD_GET,
        Request::METHOD_POST,
        Request::METHOD_PUT,
        Request::METHOD_PATCH,

    ];

    public function __construct(
        private readonly SerializerInterface $serializer
    )
    {
    }

    /**
     * @param Request $request The HTTP request to transform.
     * @param string $dtoClass The DTO class to which the request will be transformed.
     * @return object|void The transformed DTO.
     * @throws BadRequestException If the request cannot be transformed.
     */
    public function transform(Request $request, string $dtoClass)
    {
        $this->validateContentType($request);
        $this->validateRequestMethod($request);

        if ($this->isContentMethod($request->getMethod())) {
            return $this->transformContent($request, $dtoClass);
        }

    }

    /**
     * @param Request $request The HTTP request.
     * @throws BadRequestException If the content type is not supported.
     */
    private function validateContentType(Request $request): void
    {
        if ($request->headers->get('Content-Type') !== self::ALLOWED_CONTENT_TYPE) {
            throw new BadRequestException(sprintf('[%s] is the only Content-Type allowed', self::ALLOWED_CONTENT_TYPE), Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }
    }

    /**
     * @param Request $request The HTTP request.
     * @throws BadRequestException If the method is not supported.
     */
    private function validateRequestMethod(Request $request): void
    {
        if (!in_array($request->getMethod(), self::SUPPORTED_METHODS, true)) {
            throw new BadRequestException('REST method not supported', Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }

    /**
     * @param string $method The HTTP method.
     * @return bool True if the method typically contains content.
     */
    private function isContentMethod(string $method): bool
    {
        return in_array($method, [Request::METHOD_POST, Request::METHOD_PUT, Request::METHOD_PATCH], true);
    }

    /**
     * @param Request $request The HTTP request.
     * @param string $dtoClass The DTO class to which the content will be transformed.
     * @return mixed The transformed DTO.
     * @throws BadRequestException If the content is invalid or the transformation fails.
     */
    private function transformContent(Request $request, string $dtoClass): mixed
    {
        $content = trim($request->getContent());
        if (empty($content)) {
            throw new BadRequestException('Request body cannot be empty for this method', Response::HTTP_BAD_REQUEST);
        }
        try {
            return $this->serializer->deserialize($content, $dtoClass, 'json');
        } catch (\Throwable) {
            throw new BadRequestException('Invalid JSON payload', Response::HTTP_BAD_REQUEST);
        }
    }
}


