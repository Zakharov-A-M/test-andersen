<?php declare(strict_types=1);


namespace App\Dto\Contract;


use App\Service\Validation\ValidatableInterface;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;


class ContractSearchDto implements ValidatableInterface
{
    #[Type(values: ['value' => 'array'])]
    public array $search = [];

    #[Type(values: ['value' => 'array'])]
    public array $order = ['createdAt' => 'desc'];

    #[Assert\PositiveOrZero]
    public int $offset = 0;

    #[Assert\Positive]
    public int $limit = 5;
}
