<?php

namespace Common\Infrastructure\Adapter\REST\Controller;

use Common\Infrastructure\Adapter\REST\Response\Formatter\JsonApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfoController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function __invoke(): Response
    {
       return new JsonApiResponse("hello");
    }
}