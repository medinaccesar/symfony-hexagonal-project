<?php

namespace Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonApiResponse extends JsonResponse
{
    const DEFAULT_STATUS = 200;
    const DEFAULT_MESSAGE = 'success';
    const DEFAULT_DATA_KEY = 'data';

    /**
     * Constructor.
     *
     * @param object|array|null $data The response data.
     * @param int $status HTTP status code.
     * @param string $message Response message.
     * @param bool $error Indicates if the response is an error.
     * @param string|null $dataKey Key for the data field in the response.
     */
    public function __construct(
        object|array|null $data = null,
        int $status = self::DEFAULT_STATUS,
        string $message = self::DEFAULT_MESSAGE,
        bool $error = false,
        ?string $dataKey = null
    )
    {
        $dataKey = $dataKey ?? self::DEFAULT_DATA_KEY;
        $formattedData = $this->formatBody($error, $message, $data, $dataKey);
        parent::__construct($formattedData, $status);
    }

    /**
     * Formats the response body.
     *
     * @param bool $error Indicates if the response is an error.
     * @param string $message The response message.
     * @param object|array|null $data The response data.
     * @param string $dataKey The response data key.
     * @return array The formatted response body.
     */
    private function formatBody(bool $error, string $message, object|array|null $data, string $dataKey): array
    {
        return [
            'error' => $error,
            'message' => $message,
            $dataKey => $data
        ];
    }
}
