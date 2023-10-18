<?php

declare(strict_types=1);

namespace User\Infrastructure\Framework\HTTP\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Infrastructure\Doctrine\Mapping\User;

class GetUserByIdController extends AbstractController
{
    #[Route('/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function __invoke(User $user): Response
    {
       return $this->json($user);
    }
}
