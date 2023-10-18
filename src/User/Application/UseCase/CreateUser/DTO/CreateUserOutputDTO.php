<?php

namespace User\Application\UseCase;

class CreateUserOutputDTO
{
    private function __construct(
        public readonly string $username
    ) {
    }
}
