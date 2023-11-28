<?php

declare(strict_types=1);

namespace Common\Domain\Bus\Command;

/**
 * Interface for a command bus.
 * A command bus is responsible for dispatching command objects to their appropriate handlers.
 */
interface CommandBusInterface
{
    /**
     * Dispatches a command to its appropriate handler.
     *
     * @param CommandInterface $command the command to dispatch
     */
    public function dispatch(CommandInterface $command): void;
}
