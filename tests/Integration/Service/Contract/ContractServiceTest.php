<?php

namespace App\Tests\Integration\Service\Contract;

use App\Dto\Contract\ContractDto;
use App\Tests\Integration\DatabaseTestCase;

use App\Service\Contract\ContractService;

class ContractServiceTest extends DatabaseTestCase
{
    private ContractService $contractService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contractService = self::getContainer()->get(ContractService::class);
    }

    public function testCreateContract(): void
    {
        self::bootKernel();
        $contractDto = (new ContractDto())
            ->setName(uuid_create())
            ->setNumber(uuid_create())
            ->setStartDate((new \DateTimeImmutable())->setTimestamp(123456789))
            ->setFinishDate((new \DateTimeImmutable())->setTimestamp(123456789));

        $contract = $this->contractService->createContract($contractDto);

        $this->assertEquals($contract->getName(), $contractDto->name);
        $this->assertEquals($contract->getNumber(), $contractDto->number);
        $this->assertEquals($contract->getStartDate(), $contractDto->startDate);
        $this->assertEquals($contract->getFinishDate(), $contractDto->finishDate);
    }
}
