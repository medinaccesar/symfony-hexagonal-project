<?php

declare(strict_types=1);

namespace User\Infrastructure\Framework\HTTP\Controller;

use App\User\Application\Query\GetUserByIdQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetUserByIdController extends AbstractController
{
    #[Route('/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function get($id, GetUserByIdQuery $useCase): Response
    {
        return $this->json($useCase->handle($id));
    }
}
