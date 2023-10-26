<?php
declare(strict_types=1);

namespace User\Adapter\Framework\HTTP\DTO;

use Symfony\Component\HttpFoundation\Request;

interface RequestDTO
{
    public function __construct(Request $request);
}
