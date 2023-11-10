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
        int    $status = self::DEFAULT_STATUS
    ) {
        try {
            $formattedData = $this->formatBody($data,$message);
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
     * @return array The formatted response body.
     */
    private function formatBody(?array $data,string $message): array
    {
        return [
            'message' => $message,
            'status' => $this->statusCode, // Use the parent class's statusCode property
            'data' => $data
        ];
    }
}
