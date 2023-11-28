<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\HealthCheckController;

use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Provides a simple health check endpoint for the User module.
 */
readonly class HealthCheckController
{
    /**
     * Health check endpoint.
     *
     * @return JsonApiResponse the status of the service
     */
    #[Route('/api/user/health-check', name: 'user_health_check', methods: ['GET'])]
    public function __invoke(): JsonApiResponse
    {
        return new JsonApiResponse(['status' => 'ok']);
    }
}
