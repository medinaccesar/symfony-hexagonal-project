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
final class JsonApiResponse extends JsonResponse
{
    public const string DEFAULT_TYPE = 'success';
    public const string DEFAULT_MESSAGE = 'success_response';

    /**
     * Constructor for the JsonApiResponse class.
     *
     * Sets up the JSON response with a standard format, including fields for error status,
     * message type, response message, additional data, timestamp, and path.
     *
     * @param mixed  $data    the response data
     * @param int    $status  HTTP status code, defaults to 200
     * @param string $message response message
     * @param string $type    Type of response, e.g., 'success' or 'error'.
     * @param bool   $error   indicates if the response is an error
     */
    public function __construct(
        $data = null,
        int $status = self::HTTP_OK,
        string $message = self::DEFAULT_MESSAGE,
        string $type = self::DEFAULT_TYPE,
        bool $error = false
    ) {
        $formattedData = [
            'error' => $error,
            'type' => $type,
            'message' => $message,
            'data' => $data,
        ];
        parent::__construct($formattedData, $status);
    }

    /**
     * Creates a standard get response.
     *
     * @param mixed|null $data    the data to be returned
     * @param string     $message the message
     */
    public static function get(mixed $data = null, string $message = self::DEFAULT_MESSAGE): self
    {
        return new self($data, self::HTTP_OK, $message, self::DEFAULT_TYPE, false);
    }

    /**
     * Creates a standard create response.
     *
     * @param mixed|null $data    the created data
     * @param string     $message the success message for creation
     */
    public static function create(mixed $data = null, string $message = 'created'): self
    {
        return new self($data, self::HTTP_CREATED, $message, self::DEFAULT_TYPE, false);
    }
}
