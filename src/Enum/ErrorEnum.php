<?php declare(strict_types=1);


namespace App\Enum;


enum ErrorEnum
{
    case DEFAULT_ERROR;
    case NOT_FOUND_ERROR;
    case VALIDATION_ERROR;
}
