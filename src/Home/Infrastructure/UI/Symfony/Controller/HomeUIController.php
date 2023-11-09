<?php

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
            'version' => '0.0.1',
            'date' => (new DateTime())->format(DateTimeInterface::RFC850),
        ];
        return $this->render('@Home/home.twig', [
            'apiMeta' => $apiMeta,
        ]);
    }
}