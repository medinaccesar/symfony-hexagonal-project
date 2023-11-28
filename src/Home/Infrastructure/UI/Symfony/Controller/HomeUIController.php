<?php

declare(strict_types=1);

namespace Home\Infrastructure\UI\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeUIController extends AbstractController
{
    /**
     * Responds to the '/ui' route.
     *
     * Renders the home page user interface using Twig with API metadata.
     * The metadata includes the API version and the current date and time.
     *
     * @return Response the rendered Twig template for the home page UI
     *
     * @Route("/ui", name="home_ui")
     */
    public function __invoke(): Response
    {
        // Preparing API metadata
        $apiMeta = [
            'version' => '0.9.0b', // The version of the API
            'date' => (new \DateTime())->format(\DateTimeInterface::ATOM),
        ];

        // Returning the rendered Twig template with the API metadata
        return $this->render('@Home/home.twig', [
            'apiMeta' => $apiMeta,
        ]);
    }
}
