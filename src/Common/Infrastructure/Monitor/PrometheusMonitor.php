<?php

namespace Common\Infrastructure\Monitor;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\APC;
use Prometheus\Storage\Redis;

/**
 * Manages a Prometheus metrics collection registry.
 *
 * This class encapsulates the creation and management of a Prometheus CollectorRegistry,
 * which is used to register and collect metrics data. It utilizes APC (Alternative PHP Cache)
 * as the storage adapter for storing the metrics.
 */
final class PrometheusMonitor
{
    private CollectorRegistry $registry;

    /**
     * Initializes the PrometheusMonitor with a CollectorRegistry using APC storage.
     */
    public function __construct()
    {
        $this->registry = new CollectorRegistry(new Redis(['host' => $_ENV["REDIS_HOST"], 'port' => $_ENV["REDIS_PORT"]]));
    }

    /**
     * Retrieves the CollectorRegistry instance.
     *
     * This method provides access to the CollectorRegistry, allowing the application
     * to register and collect metrics.
     *
     * @return CollectorRegistry The CollectorRegistry instance.
     */
    public function registry(): CollectorRegistry
    {
        return $this->registry;
    }
}
