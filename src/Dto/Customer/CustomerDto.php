<?php declare(strict_types=1);


namespace App\Dto\Customer;


use DateTimeImmutable;

use App\Service\Validation\ValidatableInterface;


class CustomerDto implements ValidatableInterface
{
    public string $firstName;

    public string $lastName;

    public bool $isActive;

    public DateTimeImmutable $createdAt;

    public DateTimeImmutable $updatedAt;
}
