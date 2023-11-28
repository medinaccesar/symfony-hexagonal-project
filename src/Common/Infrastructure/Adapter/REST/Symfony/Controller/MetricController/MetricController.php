<?php

namespace Common\Infrastructure\Adapter\REST\Symfony\Controller\MetricController;

use Common\Infrastructure\Monitor\PrometheusMonitor;
use Prometheus\RenderTextFormat;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final readonly class MetricController
{
    public function __construct(
        private PrometheusMonitor $monitor
    ) {
    }

    #[Route('/metrics', name: 'app_metrics', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $renderer = new RenderTextFormat();
        $result = $renderer->render($this->monitor->registry()->getMetricFamilySamples());

        return new Response($result, 200, ['Content-Type' => RenderTextFormat::MIME_TYPE]);
    }
}
