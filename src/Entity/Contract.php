<?php declare(strict_types=1);


namespace App\Entity;


use DateTimeImmutable;

use App\Repository\ContractRepository;
use App\Service\Validation\ValidatableInterface;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ContractRepository::class)]
#[UniqueEntity(fields: ['number'])]
class Contract implements ValidatableInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    private int $id;

    #[ORM\Column(name: 'number', length: 15, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 15)]
    private string $number;

    #[ORM\Column(name: 'start_date', type: Types::DATE_IMMUTABLE)]
    #[Type(values: ['value' => "DateTimeImmutable<'Y-m-d'>"])]
    #[Assert\NotBlank]
    private DateTimeImmutable $startDate;

    #[ORM\Column(name: 'finish_date', type: Types::DATE_IMMUTABLE, nullable: true)]
    #[Type(values: ['value' => "DateTimeImmutable<'Y-m-d'>"])]
    private DateTimeImmutable $finishDate;

    #[ORM\Column(name: 'name', type: Types::TEXT)]
    #[Assert\NotBlank]
    private string $name;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Type(values: ['value' => "DateTimeImmutable<'Y-m-d H:i:s'>"])]
    #[Assert\NotBlank]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Type(values: ['value' => "DateTimeImmutable<'Y-m-d H:i:s'>"])]
    #[Assert\NotBlank]
    private DateTimeImmutable $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getFinishDate(): DateTimeImmutable
    {
        return $this->finishDate;
    }

    public function setFinishDate(DateTimeImmutable $finishDate): self
    {
        $this->finishDate = $finishDate;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
