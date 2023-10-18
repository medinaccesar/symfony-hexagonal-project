<?php

declare(strict_types=1);

namespace User\Infrastructure\Framework\HTTP\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\UseCase\CreateUser;
use User\Application\UseCase\CreateUserInputDTO;

class CreateUserController extends AbstractController
{
    #[Route('/create', name: 'create_user', methods: ['POST'])]
    public function __invoke(Request $request, CreateUser $service): Response
    {
        $user = CreateUserInputDTO::create(
            $request->get('username'),
            $request->get('password'),
            $request->get('roles')
        );
        
        $service->handle(...$user);
        dd($user);

        return $this->json($request->get('username'));
    }
}
