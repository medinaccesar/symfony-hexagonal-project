<?php

declare(strict_types=1);

namespace Common\Domain\Exception;

use Common\Domain\Exception\Constant\ExceptionMessage;

class ResourceNotFoundException extends ApiException
{
    const STATUS_CODE = 404;

    public function __construct()
    {
        parent::__construct(self::STATUS_CODE, ExceptionMessage::NOT_FOUND);
    }
}
