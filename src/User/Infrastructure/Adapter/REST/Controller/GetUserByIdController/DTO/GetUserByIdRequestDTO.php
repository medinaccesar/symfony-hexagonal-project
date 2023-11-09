<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\GetUserByIdController\DTO;

use Common\Infrastructure\Adapter\REST\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

readonly class GetUserByIdRequestDTO implements RequestDTO
{
    public ?string $id;

    public function __construct(Request $request)
    {
        $this->id = $request->attributes->get('id');
    }
}
