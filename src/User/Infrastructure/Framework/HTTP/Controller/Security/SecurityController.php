<?php

declare(strict_types=1);

namespace User\Infrastructure\Framework\HTTP\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Infrastructure\Persistence\Mapping\User;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function __invoke(User $user): Response
    {
        return $this->json($user);
    }
}
