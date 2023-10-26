<?php

declare(strict_types=1);

namespace User\Adapter\Framework\HTTP\DTO;

use Symfony\Component\HttpFoundation\Request;
use Api\Adapter\Framework\HTTP\DTO\RequestDTO;

readonly class GetUserByIdRequestDTO implements RequestDTO
{
    public ?string $id;

    public function __construct(Request $request)
    {
        $this->id = $request->attributes->get('id');
    }
}
