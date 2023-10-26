<?php

declare(strict_types=1);

namespace User\Adapter\Framework\HTTP\Controller;

use User\Application\Command\CreateUser\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateUserController extends AbstractController
{
    #[Route('/create', name: 'create_user', methods: ['POST'])]
    public function __invoke(Request $request, CreateUserCommand $service): Response
    {
    }
}
