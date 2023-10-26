<?php

namespace User\Adapter\Framework\HTTP\DTO;

use Symfony\Component\HttpFoundation\Request;

readonly class GetUserByIdRequestDTO
{
    public ?string $id;

    public function __construct(Request $request)
    {
        $this->id = $request->attributes->get('id');
    }
}
