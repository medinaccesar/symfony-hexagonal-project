<?php

namespace Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter;

use Symfony\Component\HttpFoundation\JsonResponse;


class JsonApiResponse extends JsonResponse
{

    const DEFAULT_STATUS = 200;
    const DEFAULT_MESSAGE = 'success';

    /**
     * @param object|array|null $data The response data or validation violations.
     * @param int $status The HTTP status code.
     * @param string $message The response message.
     * @param bool $error Indicates if the response is an error (defaults to false).
     * @param string|null $class The error class, if applicable.
     */
    public function __construct(
        object|array|null $data,
        int               $status = self::DEFAULT_STATUS,
        string            $message = self::DEFAULT_MESSAGE,
        bool              $error = false, // Error is false by default, indicating a successful response
        ?string           $class = null // Optional error class, used in error responses
    )
    {
        $formattedData = $this->formatBody($data, $message, $error, $class);
        parent::__construct($formattedData, $status);
    }

    /**
     * Formats the response body based on whether it's an error or a successful response.
     *
     * @param object|array|null $data The response data or validation violations.
     * @param string $message The response message.
     * @param bool $error Indicates if the response is an error.
     * @param string|null $class The error class, if applicable.
     * @return array The formatted response body.
     */
    private function formatBody(object|array|null $data, string $message, bool $error, ?string $class): array
    {
        // Use 'violations' for errors, 'data' for successful responses
        $key = $error ? 'violations' : 'data';

        return [
            'error' => $error,
            'message' => $message,
            'class' => $class,
            $key => $data
        ];
    }
}


