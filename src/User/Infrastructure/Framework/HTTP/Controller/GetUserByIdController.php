<?php

declare(strict_types=1);

namespace User\Infrastructure\Framework\HTTP\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\UseCase\GetUserById\GetUserByIdUseCase;

class GetUserByIdController extends AbstractController
{
    #[Route('/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function get($id, GetUserByIdUseCase $useCase): Response
    {
        return $this->json($useCase->handle($id));
    }
}
