<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\ErrorEnum;
use App\Enum\HttpStatusEnum;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \Exception implements PublicExceptionInterface
{
    public const ERROR = ErrorEnum::VALIDATION_ERROR;

    public const CODE = HttpStatusEnum::UNPROCESSABLE_ENTITY;

    private ConstraintViolationListInterface $errors;

    public function __construct(ConstraintViolationListInterface $errors, string $message, int $code, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public static function create(ConstraintViolationListInterface $errors): self
    {
        return new self($errors, static::ERROR->name, static::CODE->value);
    }

    public function getData(): array
    {
        $errors = [];

        foreach ($this->errors as $error) {
            $errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return [
            'error' => $this->getMessage(),
            'data' => $errors,
        ];
    }
}
