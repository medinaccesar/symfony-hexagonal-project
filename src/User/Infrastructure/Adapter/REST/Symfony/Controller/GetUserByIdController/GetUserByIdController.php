<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\GetUserByIdController;

use Common\Infrastructure\Adapter\REST\Symfony\Controller\ApiController\ApiController;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Query\GetUserById\GetUserByIdQuery;
use User\Application\Query\GetUserById\GetUserByIdResponse;

readonly class GetUserByIdController extends ApiController
{
    /**
     * Retrieves a user by their uuid.
     *
     * @param string $id the Uuid of the user
     *
     * @return JsonApiResponse the response in JSON format
     */
    #[Route('/api/user/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function __invoke(string $id): JsonApiResponse
    {
        /** @var GetUserByIdResponse $response */
        $response = $this->ask(new GetUserByIdQuery($id));

        return JsonApiResponse::get($response);
    }
}
