<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ;
use AMQPException;
use Common\Domain\Bus\Event\EventBusInterface;

final readonly class RabbitMqEventBus implements EventBusInterface
{
	public function __construct(
		private RabbitMqConnection $connection,
		private string $exchangeName,
		private MySqlDoctrineEventBus $failoverPublisher
	) {}

	public function publish(DomainEvent ...$events): void
	{
		each($this->publisher(), $events);
	}

	private function publisher(): callable
	{
		return function (DomainEvent $event): void {
			try {
				$this->publishEvent($event);
			} catch (AMQPException) {
				$this->failoverPublisher->publish($event);
			}
		};
	}

	private function publishEvent(DomainEvent $event): void
	{
		$body = DomainEventJsonSerializer::serialize($event);
		$routingKey = $event::eventName();
		$messageId = $event->eventId();

		$this->connection->exchange($this->exchangeName)->publish(
			$body,
			$routingKey,
			AMQP_NOPARAM,
			[
				'message_id' => $messageId,
				'content_type' => 'application/json',
				'content_encoding' => 'utf-8',
			]
		);
	}
}