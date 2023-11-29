<?php

namespace Common\Infrastructure\Adapter\REST\Symfony\Controller\ApiController;

use Common\Domain\Bus\Command\CommandBusInterface;
use Common\Domain\Bus\Command\CommandInterface;
use Common\Domain\Bus\Query\QueryBusInterface;
use Common\Domain\Bus\Query\QueryInterface;
use Common\Domain\Bus\Query\QueryResponseInterface;

abstract readonly class ApiController
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
    ) {
    }

    protected function ask(QueryInterface $query): QueryResponseInterface
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
