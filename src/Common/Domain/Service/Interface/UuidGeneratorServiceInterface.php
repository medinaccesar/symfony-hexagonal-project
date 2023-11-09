<?php

namespace Common\Domain\Service\Interface;

interface UuidGeneratorServiceInterface
{
    public function generateUuid(): string;
    public function validateUuid($uuid): string;

}