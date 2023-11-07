<?php

namespace Api\Adapter\Framework\HTTP\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function __invoke(): Response
    {
       return new JsonResponse("hello");
    }
}