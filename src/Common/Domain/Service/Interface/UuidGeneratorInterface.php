<?php

namespace Common\Domain\Service\Interface;

interface UuidGeneratorInterface
{
    public function generateUuid(): string;
}