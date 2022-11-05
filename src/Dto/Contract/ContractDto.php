<?php declare(strict_types=1);


namespace App\Dto\Contract;


use DateTimeImmutable;

use App\Service\Validation\ValidatableInterface;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;


class ContractDto implements ValidatableInterface
{
    public int $id;

    #[Assert\NotBlank(groups: ['new'])]
    #[Assert\Length(max: 15)]
    public string $number;

    #[Assert\NotBlank(groups: ['new'])]
    #[Type(values: ['value' => "DateTimeImmutable<'Y-m-d'>"])]
    public DateTimeImmutable $startDate;

    #[Assert\NotBlank(groups: ['new'])]
    #[Type(values: ['value' => "DateTimeImmutable<'Y-m-d'>"])]
    public DateTimeImmutable $finishDate;

    #[Assert\NotBlank(groups: ['new'])]
    #[Assert\Length(max: 1000)]
    public string $name;

    public DateTimeImmutable $createdAt;

    public DateTimeImmutable $updatedAt;
}
