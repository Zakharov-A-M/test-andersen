<?php declare(strict_types=1);


namespace App\Enum;


enum HttpStatusEnum: int
{
    case OK = 200;
    case CREATED = 201;
    case NO_CONTENT = 204;

    case NOT_FOUND = 404;
    case UNPROCESSABLE_ENTITY = 422;

    case INTERNAL_SERVER_ERROR = 500;
}
