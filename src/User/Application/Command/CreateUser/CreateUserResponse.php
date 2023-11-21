<?php

declare(strict_types=1);

namespace User\Application\Command\CreateUser;


final readonly class CreateUserResponse
{
    public function __construct(
        public string $id
    )
    {
    }
}