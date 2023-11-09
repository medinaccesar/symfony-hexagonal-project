<?php

namespace Common\Infrastructure\Adapter\REST\Response\Formatter;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonApiResponse extends JsonResponse
{
    public function __construct($data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        $data = $this->formatData($data);
        parent::__construct($data, $status, $headers, $json);
    }

    private function formatData($data): array
    {
        // JSON:REST convention
        return [
            'data' => $data,
            'links' => [
                // Enlaces relacionados
            ],
            'meta' => [
                // Metadatos adicionales
            ],
        ];
    }
}
