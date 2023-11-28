<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus\Event\RabbitMQ;

/**
 * Manages RabbitMQ connections, channels, exchanges, and queues.
 */
final class RabbitMqConnection
{
    private static ?\AMQPConnection $connection = null;
    private static ?\AMQPChannel $channel = null;

    /** @var \AMQPExchange[] */
    private static array $exchanges = [];

    /** @var \AMQPQueue[] */
    private static array $queues = [];

    public function __construct(
        private readonly array $configuration
    ) {
    }

    /**
     * Retrieves or creates a queue with the given name.
     * Utilizes a static array to manage queue instances.
     *
     * @param string $name queue name
     *
     * @return \AMQPQueue the requested queue
     */
    public function queue(string $name): \AMQPQueue
    {
        if (!isset(self::$queues[$name])) {
            try {
                $queue = new \AMQPQueue($this->channel());
                $queue->setName($name);
                self::$queues[$name] = $queue;
            } catch (\AMQPConnectionException|\AMQPQueueException) {
                // TODO catch
            }
        }

        return self::$queues[$name];
    }

    /**
     * Retrieves or creates an exchange with the given name.
     * Utilizes a static array to manage exchange instances.
     *
     * @param string $name exchange name
     *
     * @return \AMQPExchange the requested exchange
     */
    public function exchange(string $name): \AMQPExchange
    {
        if (!isset(self::$exchanges[$name])) {
            try {
                $exchange = new \AMQPExchange($this->channel());
                $exchange->setName($name);
                self::$exchanges[$name] = $exchange;
            } catch (\AMQPConnectionException|\AMQPExchangeException $e) {
            }
        }

        return self::$exchanges[$name];
    }

    /**
     * Provides the AMQP channel, creating it if necessary.
     * Ensures the channel is connected before returning it.
     *
     * @return \AMQPChannel the AMQP channel
     *
     * @throws \AMQPConnectionException if the channel creation fails
     */
    private function channel(): \AMQPChannel
    {
        if (null === self::$channel || !self::$channel->isConnected()) {
            self::$channel = new \AMQPChannel($this->connection());
        }

        return self::$channel;
    }

    /**
     * Provides the AMQP connection, creating it if necessary.
     * Ensures the connection is active before returning it.
     *
     * @return \AMQPConnection the AMQP connection
     *
     * @throws \AMQPConnectionException if the connection creation fails
     */
    private function connection(): \AMQPConnection
    {
        if (null === self::$connection || !self::$connection->isConnected()) {
            self::$connection = new \AMQPConnection($this->configuration);
            self::$connection->pconnect();
        }

        return self::$connection;
    }
}
