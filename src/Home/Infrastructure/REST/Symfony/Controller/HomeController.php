<?php

namespace Home\Infrastructure\REST\Symfony\Controller;

use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use DateTime;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function __invoke(): Response
    {
        $apiMeta = [
            'version' => '0.0.1',
            'date' => (new DateTime())->format(DateTimeInterface::RFC850),
        ];
        return new JsonApiResponse($apiMeta);
    }
}