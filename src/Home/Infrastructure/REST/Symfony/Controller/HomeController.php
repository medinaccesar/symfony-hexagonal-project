<?php

declare(strict_types=1);

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
            'version' => '0.9.0b',
            'date' => (new DateTime())->format(DateTimeInterface::ATOM),
        ];
        return new JsonApiResponse($apiMeta);
    }
}