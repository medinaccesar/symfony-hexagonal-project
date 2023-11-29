<?php

namespace Common\Infrastructure\Bus\Command\Symfony;

use Common\Domain\Bus\Command\CommandBusInterface;
use Common\Domain\Bus\Command\CommandInterface;
use Common\Domain\Exception\CommandNotRegisteredException;
use Common\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

/**
 * Class InMemorySymfonyCommandBus.
 *
 * This class implements the CommandBusInterface and provides an in-memory command bus.
 * It uses Symfony's MessageBus to handle commands.
 */
final readonly class InMemorySymfonyCommandBus implements CommandBusInterface
{
    /**
     * @var MessageBus the message bus used to handle commands
     */
    private MessageBus $bus;

    /**
     * InMemorySymfonyCommandBus constructor.
     *
     * Initializes the message bus with a middleware that uses a handlers locator,
     * which in turn uses the CallableFirstParameterExtractor to extract the first parameter for callables.
     *
     * @param iterable $commandHandlers the handlers for the commands
     */
    public function __construct(iterable $commandHandlers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        CallableFirstParameterExtractor::forCallables($commandHandlers)
                    )
                ),
            ]
        );
    }

    /**
     * Dispatches a command.
     *
     * Dispatches the command to the message bus.
     * If no handler is found for the message, it throws a CommandNotRegisteredException.
     * If the handler fails, it throws the previous exception or the HandlerFailedException itself.
     *
     * @param CommandInterface $command the command to dispatch
     *
     * @throws \Throwable if the handler fails
     */
    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            throw new CommandNotRegisteredException($command);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}
