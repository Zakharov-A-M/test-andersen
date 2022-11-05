<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ErrorEnum;
use App\Enum\HttpStatusEnum;

class NotFoundException extends ApiPublicException
{
    public const ERROR = ErrorEnum::NOT_FOUND_ERROR;

    public const CODE = HttpStatusEnum::NOT_FOUND;
}
