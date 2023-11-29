<?php

namespace Common\Domain\Exception;

use Common\Domain\Bus\Command\CommandInterface;

final class CommandNotRegisteredException extends \RuntimeException
{
    public function __construct(CommandInterface $command)
    {
        $commandClass = $command::class;

        parent::__construct("The command <$commandClass> hasn't a command handler associated");
    }
}
