<?php

declare(strict_types=1);

namespace Common\Domain\Exception;

use Common\Domain\Exception\Constant\ExceptionMessage;

class DuplicateValidationResourceException extends ApiException
{
    const STATUS_CODE = 409;

    public function __construct()
    {
        parent::__construct(self::STATUS_CODE, ExceptionMessage::DUPLICATE);
    }
}
