<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Dto\Contract\ContractDto;
use App\Repository\ContractRepository;
use App\Service\Contract\ContractService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContractServiceTest extends TestCase
{
    private EntityManagerInterface $entityManagerMock;
    private ValidatorInterface $validatorInterfaceMock;
    private ContractRepository $contractRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->validatorInterfaceMock = $this->createMock(ValidatorInterface::class);
        $this->contractRepositoryMock = $this->createMock(ContractRepository::class);
    }

    public function testCreateContract(): void
    {
        $contractDto = (new ContractDto())
            ->setId(10)
            ->setName(uuid_create())
            ->setNumber('564646')
            ->setStartDate((new \DateTimeImmutable())->setTimestamp(123456789))
            ->setFinishDate((new \DateTimeImmutable())->setTimestamp(123456789));

        $contractService = new ContractService(
            $this->entityManagerMock,
            $this->validatorInterfaceMock,
            $this->contractRepositoryMock
        );

        /** @var ContractDto $contractNew */
        $contractNew = $contractService->testTest($contractDto);

        $this->assertEquals($contractNew->name, 'broken test');
        $this->assertEquals($contractNew->id, $contractDto->id);
        $this->assertEquals($contractNew->number, $contractDto->number);
        $this->assertEquals($contractNew->startDate, $contractDto->startDate);
        $this->assertEquals($contractNew->finishDate, $contractDto->finishDate);
    }
}
