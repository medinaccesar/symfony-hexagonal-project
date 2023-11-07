<?php

declare(strict_types=1);

namespace User\Adapter\Framework\HTTP\Controller\GetUserByIdController\DTO;

use Api\Adapter\Framework\HTTP\Controller\DTO\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

readonly class GetUserByIdRequestDTO implements RequestDTO
{
    public ?string $id;

    public function __construct(Request $request)
    {
        $this->id = $request->attributes->get('id');
    }

}
