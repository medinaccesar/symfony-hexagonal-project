<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\Monitoring;

use Common\Domain\Bus\Event\DomainEvent;
use Common\Domain\Bus\Event\EventBusInterface;
use Common\Infrastructure\Monitor\PrometheusMonitor;

/**
 * An event bus that integrates monitoring capabilities using Prometheus.
 *
 * This class implements the EventBusInterface and decorates any EventBus with
 * monitoring capabilities, incrementing a counter in Prometheus every time
 * a domain event is published.
 */
final readonly class PrometheusMonitoringEventBus implements EventBusInterface
{
    public function __construct(
        private EventBusInterface $bus,
        private PrometheusMonitor $monitor,
        private string            $appName
    )
    {
    }

    /**
     * Publishes domain events and records each event in Prometheus.
     *
     * Increments a counter in Prometheus for each published domain event,
     * tagged by the event's name, before passing the event on to the
     * underlying event bus for handling.
     *
     * @param DomainEvent ...$events A variadic list of domain events to be published.
     * @return void
     */
    public function publish(DomainEvent ...$events): void
    {
        // Retrieve or register a counter in Prometheus for domain events.
        $counter = $this->monitor->registry()->getOrRegisterCounter(
            $this->appName,
            'domain_event',
            'Domain Events',
            ['name']
        );

        // Increment the counter for each received domain event.
        foreach ($events as $event) {
            $counter->inc(['name' => $event::eventName()]);
        }

        // Delegate the event publishing to the underlying event bus.
        $this->bus->publish(...$events);
    }
}
