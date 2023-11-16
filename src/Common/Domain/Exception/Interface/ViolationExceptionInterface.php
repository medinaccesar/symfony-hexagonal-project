<?php

namespace Common\Domain\Exception\Interface;

interface ViolationExceptionInterface
{
    public function getViolations(): array;

}