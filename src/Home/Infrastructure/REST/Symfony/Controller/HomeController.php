<?php

declare(strict_types=1);

namespace Home\Infrastructure\REST\Symfony\Controller;

use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * HomeController serves the root URL of the API.
 * It returns basic API metadata in JSON format.
 */
class HomeController extends AbstractController
{
    /**
     * Handles the request to the root URL ('/').
     *
     * @return Response the JSON-formatted API metadata
     *
     * @Route("/", name="home")
     */
    public function __invoke(): Response
    {
        $apiMeta = [
            'version' => '0.9.0b', // API version
            'date' => (new \DateTime())->format(\DateTimeInterface::ATOM),
        ];

        return new JsonApiResponse($apiMeta);
    }
}
