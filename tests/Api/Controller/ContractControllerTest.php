<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller;

use App\Dto\Contract\ContractDto;
use App\Tests\Api\DatabaseApiTestCase;

class ContractControllerTest extends DatabaseApiTestCase
{
    public function testCreateContractAction(): void
    {
        $contractDto = (new ContractDto())
            ->setName(uuid_create())
            ->setNumber(uuid_create())
            ->setStartDate((new \DateTimeImmutable())->setTimestamp(123456789))
            ->setFinishDate((new \DateTimeImmutable())->setTimestamp(123456789));

        $this->client->request('POST', '/v1/contracts/', [], [], [], $this->getRequestBody($contractDto));
        self::assertEquals(201, $this->client->getResponse()->getStatusCode());

        $content = json_decode($this->client->getResponse()->getContent(), true);
        self::assertTrue($content['success']);
        self::assertEquals($content['data']['number'], $contractDto->number);
        self::assertEquals($content['data']['name'], $contractDto->name);
        self::assertEquals($content['data']['start_date'], $contractDto->startDate->format('Y-m-d'));
        self::assertEquals($content['data']['finish_date'], $contractDto->finishDate->format('Y-m-d'));
    }
}
