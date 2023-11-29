<?php

namespace Common\Infrastructure\Bus\Query\Symfony;

use Common\Domain\Bus\Query\QueryBusInterface;
use Common\Domain\Bus\Query\QueryInterface;
use Common\Domain\Bus\Query\QueryResponseInterface;
use Common\Domain\Exception\QueryNotRegisteredException;
use Common\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Class InMemorySymfonyQueryBus.
 *
 * This class implements the QueryBusInterface and provides an in-memory query bus.
 * It uses Symfony's MessageBus to handle queries.
 */
final readonly class InMemorySymfonyQueryBus implements QueryBusInterface
{
    /**
     * @var MessageBus the message bus used to handle queries
     */
    private MessageBus $bus;

    /**
     * InMemorySymfonyQueryBus constructor.
     *
     * Initializes the message bus with a middleware that uses a handlers locator,
     * which in turn uses the CallableFirstParameterExtractor to extract the first parameter for callables.
     *
     * @param iterable $queryHandlers the handlers for the queries
     */
    public function __construct(iterable $queryHandlers)
    {
        $this->bus = new MessageBus([
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        CallableFirstParameterExtractor::forCallables($queryHandlers)
                    )
                ),
            ]
        );
    }

    /**
     * Asks a query and returns the response.
     *
     * Dispatches the query to the message bus and returns the result.
     * If no handler is found for the message, it throws a QueryNotRegisteredException.
     *
     * @param QueryInterface $query the query to ask
     *
     * @return QueryResponseInterface the response to the query
     *
     * @throws QueryNotRegisteredException if no handler is found for the query
     */
    public function ask(QueryInterface $query): QueryResponseInterface
    {
        try {
            /* @var HandledStamp $stamp */
            return $this->bus->dispatch($query)->last(HandledStamp::class)->getResult();
        } catch (NoHandlerForMessageException) {
            throw new QueryNotRegisteredException($query);
        }
    }
}
