<?php

namespace Common\Infrastructure\Adapter\REST\Symfony\Controller\MetricController;

use Common\Infrastructure\Monitor\PrometheusMonitor;
use Prometheus\RenderTextFormat;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * MetricController is responsible for handling requests to the '/metrics' endpoint.
 * It uses PrometheusMonitor to collect and render metrics in a Prometheus-compatible format.
 */
final class MetricController
{
    /**
     * @var PrometheusMonitor The Prometheus monitoring service
     */
    private PrometheusMonitor $monitor;

    /**
     * Constructor for MetricController.
     *
     * @param PrometheusMonitor $monitor the Prometheus monitoring service
     */
    public function __construct(PrometheusMonitor $monitor)
    {
        $this->monitor = $monitor;
    }

    /**
     * Handles the request to the '/metrics' endpoint.
     *
     * @param Request $request the incoming HTTP request
     *
     * @return Response the HTTP response with Prometheus metrics
     *
     * @Route("/metrics", name="app_metrics", methods={"GET"})
     */
    public function __invoke(Request $request): Response
    {
        // Create a renderer for Prometheus text format.
        $renderer = new RenderTextFormat();

        // Retrieve metric family samples from the Prometheus registry and render them.
        $result = $renderer->render($this->monitor->registry()->getMetricFamilySamples());

        return new Response($result, Response::HTTP_OK, ['Content-Type' => RenderTextFormat::MIME_TYPE]);
    }
}
