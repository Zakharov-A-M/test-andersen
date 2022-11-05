<?php declare(strict_types=1);


namespace App\Exception;

use App\Enum\ErrorEnum;
use App\Enum\HttpStatusEnum;


class NotFoundException extends ApiPublicException
{
    const ERROR = ErrorEnum::NOT_FOUND_ERROR;

    const CODE = HttpStatusEnum::NOT_FOUND;
}
