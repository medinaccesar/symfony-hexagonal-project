<?php

namespace Common\Domain\Bus\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): QueryResponseInterface;
}
