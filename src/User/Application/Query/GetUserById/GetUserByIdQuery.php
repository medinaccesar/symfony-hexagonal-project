<?php

declare(strict_types=1);

namespace User\Application\Query\GetUserById;

readonly class GetUserByIdQuery
{
    public function __construct(
        public string $userId
    ) {
    }
}
