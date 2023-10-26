<?php

declare(strict_types=1);

namespace User\Adapter\Framework\HTTP\Controller;

use User\Adapter\Framework\HTTP\DTO\GetUserByIdRequestDTO;
use User\Application\Query\GetUserById\DTO\GetUserByIdInputDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Query\GetUserById\GetUserByIdQuery;

class GetUserByIdController extends AbstractController
{
    public function __construct(
        private readonly GetUserByIdQuery $query
    )
    {
    }

    #[Route('/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function get(GetUserByIdRequestDTO $request): Response
    {
        $responseDTO = $this->query->handle(
            GetUserByIdInputDTO::create($request->id));
        return $this->json($responseDTO);
    }
}
