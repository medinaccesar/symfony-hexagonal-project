<?php

namespace User\Application\Query\GetUserById;

readonly class GetUserByIdResponse
{
    public function __construct(
        public string $id,
        public string $username,
        public array  $roles,
    ) {}
}
