<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\REST\Symfony\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestDTO
{
    public function __construct(Request $request);
}
