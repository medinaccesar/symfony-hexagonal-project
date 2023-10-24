<?php

declare(strict_types=1);

namespace User\Infrastructure\Framework\HTTP\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\UseCase\CreateUser\CreateUser;

class CreateUserController extends AbstractController
{
    #[Route('/create', name: 'create_user', methods: ['POST'])]
    public function __invoke(Request $request, CreateUser $service): Response
    {
    }
}
