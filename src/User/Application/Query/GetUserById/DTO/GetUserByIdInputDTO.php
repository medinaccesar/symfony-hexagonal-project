<?php

namespace User\Application\Query\GetUserById\DTO;

use Core\Validation\Trait\AssertNotNullTrait;
use User\Adapter\Framework\HTTP\Controller\GetUserByIdController\DTO\GetUserByIdRequestDTO;

readonly class GetUserByIdInputDTO
{
    use AssertNotNullTrait;

    private const ARGS = ['id'];

    public function __construct(
        public ?string $id
    ) {
        $this->assertNotNull(self::ARGS, [$this->id]);
    }

    public static function create(GetUserByIdRequestDTO $requestDTO): self
    {
        return new static($requestDTO->id);
    }
}
