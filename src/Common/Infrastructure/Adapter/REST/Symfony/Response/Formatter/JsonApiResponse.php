<?php

namespace Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonApiResponse extends JsonResponse
{
    const DEFAULT_STATUS = 200;

    public function __construct(
        array  $data = null,
        string $message = '',
        int    $status = self::DEFAULT_STATUS,
        bool   $error = false
    )
    {
        try {
            $formattedData = $this->formatBody($error, $message, $status, $data);
            parent::__construct($formattedData, $status);
        } catch (Exception) {
            // Handle exceptions if needed
        }
    }

    /**
     * Formats the response body.
     *
     * @param array|null $data The response data.
     * @param string $message The response message.
     * @param int $status The HTTP status code.
     * @param bool $error Indicates if the response is an error.
     * @return array The formatted response body.
     */
    private function formatBody(bool $error, string $message, int $status, ?array $data): array
    {
        return [
            'error' => $error,
            'message' => $message,
            'status' => $status, // Use the parent class's statusCode property
            'data' => $data
        ];
    }
}
