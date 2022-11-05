<?php declare(strict_types=1);


namespace App\Exception;


use Exception;
use Throwable;

use App\Enum\ErrorEnum;
use App\Enum\HttpStatusEnum;

use Symfony\Component\Validator\ConstraintViolationList;


class ValidationException extends Exception implements PublicExceptionInterface
{
    const ERROR = ErrorEnum::VALIDATION_ERROR;

    const CODE = HttpStatusEnum::UNPROCESSABLE_ENTITY;

    private ConstraintViolationList $errors;

    public function __construct(ConstraintViolationList $errors, string $message, int $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public static function create(ConstraintViolationList $errors): static
    {
        return new static($errors, static::ERROR->name, static::CODE->value);
    }

    public function getData(): array
    {
        $errors = [];

        foreach ($this->errors as $error) {
            $errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return [
            'error' => $this->getMessage(),
            'data'  => $errors,
        ];
    }
}
