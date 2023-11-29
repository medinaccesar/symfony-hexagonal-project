<?php

namespace Common\Domain\Exception;

use Common\Domain\Bus\Query\QueryInterface;

final class QueryNotRegisteredException extends \RuntimeException
{
    public function __construct(QueryInterface $query)
    {
        $queryClass = $query::class;

        parent::__construct("The query <$queryClass> has no associated query handler");
    }
}
