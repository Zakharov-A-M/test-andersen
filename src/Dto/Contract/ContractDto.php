<?php

declare(strict_types=1);

namespace App\Dto\Contract;

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
    public \DateTimeImmutable $startDate;

    #[Assert\NotBlank(groups: ['new'])]
    #[Type(values: ['value' => "DateTimeImmutable<'Y-m-d'>"])]
    public \DateTimeImmutable $finishDate;

    #[Assert\NotBlank(groups: ['new'])]
    #[Assert\Length(max: 1000)]
    public string $name;

    public \DateTimeImmutable $createdAt;

    public \DateTimeImmutable $updatedAt;

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setStartDate(\DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function setFinishDate(\DateTimeImmutable $finishDate): self
    {
        $this->finishDate = $finishDate;

        return $this;
    }
}
