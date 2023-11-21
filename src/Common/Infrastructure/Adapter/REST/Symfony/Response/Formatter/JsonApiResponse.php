<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * JsonApiResponse class to standardize JSON responses for the API.
 *
 * This class extends Symfony's JsonResponse and provides a consistent structure
 * for JSON API responses, including fields for error status, message, and additional
 * data. It is designed to make API responses more predictable and standardized.
 */
class JsonApiResponse extends JsonResponse
{
    const DEFAULT_STATUS = 200;
    const DEFAULT_TYPE = 'success';
    const DEFAULT_MESSAGE = 'OK';

    /**
     * Constructor for the JsonApiResponse class.
     *
     * Sets up the JSON response with a standard format, including fields for error status,
     * message type, response message, additional data, timestamp, and path.
     *
     * @param mixed $data The response data.
     * @param int $status HTTP status code, defaults to 200.
     * @param string $type Type of response, e.g., 'success' or 'error'.
     * @param string $message Response message.
     * @param bool $error Indicates if the response is an error.
     * @param string $timestamp Timestamp of the response.
     * @param string $path Request path related to the response.
     */
    public function __construct(
        $data = null,
        int $status = self::DEFAULT_STATUS,
        string $type = self::DEFAULT_TYPE,
        string $message = self::DEFAULT_MESSAGE,
        bool $error = false,
        string $timestamp = '',
        string $path = ''
    )
    {
        $formattedData = [
            'error' => $error,
            'type' => $type,
            'message' => $message,
            'data' => $data,
            'timestamp' => $timestamp ?: date('c'),
            'path' => $path
        ];
        parent::__construct($formattedData, $status);
    }
}
