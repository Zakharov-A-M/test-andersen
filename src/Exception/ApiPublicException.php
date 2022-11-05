<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ErrorEnum;
use App\Enum\HttpStatusEnum;

class ApiPublicException extends \Exception implements PublicExceptionInterface
{
    public const ERROR = ErrorEnum::DEFAULT_ERROR;
    public const CODE = HttpStatusEnum::INTERNAL_SERVER_ERROR;

    private array $data;

    public function __construct(array $data, string $message, int $code, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->data = $data;
    }

    public static function create(array $data): static
    {
        return new static($data, static::ERROR->name, static::CODE->value);
    }

    public function getData(): array
    {
        return [
            'error' => $this->getMessage(),
            'data' => $this->data,
        ];
    }
}
