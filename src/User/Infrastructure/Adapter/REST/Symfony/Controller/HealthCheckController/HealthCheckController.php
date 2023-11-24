<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\HealthCheckController;

use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Component\Routing\Annotation\Route;


readonly class HealthCheckController
{
    #[Route('/api/user/health-check', name: 'user_health_check', methods: ['GET'])]
    public function __invoke($id): JsonApiResponse
    {
        return new JsonApiResponse(['status' => 'ok']);
    }
}
