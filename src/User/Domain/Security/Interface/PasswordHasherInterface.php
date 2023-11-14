<?php

namespace User\Domain\Security\Interface;

interface PasswordHasherInterface
{
    public function hash(string $password): string;
    public function verify(string $hashedPassword, string $password): bool;
}