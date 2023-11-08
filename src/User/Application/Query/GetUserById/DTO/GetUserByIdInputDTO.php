<?php

namespace User\Application\Query\GetUserById\DTO;

use Core\Validation\Trait\AssertNotNullTrait;

readonly class GetUserByIdInputDTO
{
    use AssertNotNullTrait;

    private const ARGS = ['id'];

    public function __construct(
        public ?string $id
    ) {
        $this->assertNotNull(self::ARGS, [$this->id]);
    }

    public static function create($id): self
    {
        return new static($id);
    }
}
