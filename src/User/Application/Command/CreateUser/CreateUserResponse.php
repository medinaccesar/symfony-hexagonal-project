<?php

namespace User\Application\Command\CreateUser;

readonly class CreateUserResponse
{
    public function __construct(
       public string $userId
    )
    {
    }

}