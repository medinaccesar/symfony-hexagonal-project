<?php

declare(strict_types=1);

namespace Home\Infrastructure\UI\Symfony\Controller;

use DateTime;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeUIController extends AbstractController
{
    #[Route('/ui', name: 'home_ui')]
    public function __invoke(): Response
    {
        $apiMeta = [
            'version' => '0.9.0b',
            'date' => (new DateTime())->format(DateTimeInterface::RFC850),
        ];
        return $this->render('@Home/home.twig', [
            'apiMeta' => $apiMeta,
        ]);
    }
}