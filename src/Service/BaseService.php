<?php declare(strict_types=1);


namespace App\Service;


use App\Exception\ValidationException;
use App\Service\Validation\ValidatableInterface;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class BaseService
{
    protected EntityManagerInterface $entityManager;

    protected ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator     = $validator;
    }

    /**
     * @param ValidatableInterface $validatable Validatable
     *
     * @return void
     * @throws ValidationException
     */
    protected function validate(ValidatableInterface $validatable, array $groups = null): void
    {
        $errors = $this->validator->validate($validatable, null, $groups);

        if (count($errors)) {
            throw ValidationException::create($errors);
        }
    }
}
