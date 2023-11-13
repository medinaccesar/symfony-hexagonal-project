<?php

namespace Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonApiResponse extends JsonResponse
{
    const DEFAULT_STATUS = 200;
    const DEFAULT_MESSAGE = 'success';


    public function __construct(
        object|array|null $data = null,
        int               $status = self::DEFAULT_STATUS,
        string            $message = self::DEFAULT_MESSAGE,
        bool              $error = false
    )
    {
        $formattedData = $this->formatBody($error, $status, $message, $data);
        parent::__construct($formattedData, $status);
    }

    /**
     * Formats the response body.
     *
     * @param bool $error Indicates if the response is an error.
     * @param string $message The response message.
     * @param int $status The HTTP status code.
     * @param object|array|null $data The response data.
     * @return array The formatted response body.
     */
    private function formatBody(bool $error, int $status, string $message, object|array|null $data): array
    {
        return [
            'error' => $error,
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }
}
