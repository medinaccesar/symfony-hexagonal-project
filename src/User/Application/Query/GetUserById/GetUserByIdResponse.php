<?php

declare(strict_types=1);

namespace User\Application\Query\GetUserById;

readonly class GetUserByIdResponse
{
    public function __construct(
        public string $id,
        public string $username,
        public array  $roles,
    )
    {
    }
}
