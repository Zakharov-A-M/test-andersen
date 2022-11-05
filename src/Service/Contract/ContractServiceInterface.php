<?php

declare(strict_types=1);

namespace App\Service\Contract;

use App\Dto\Contract\ContractDto;
use App\Dto\Contract\ContractSearchDto;
use App\Entity\Contract;
use App\Exception\ValidationException;

interface ContractServiceInterface
{
    /**
     * @return Contract[]
     *
     * @throws ValidationException
     */
    public function getContracts(ContractSearchDto $contractSearchDto): array;

    public function getContract(int $id): Contract;

    public function createContract(ContractDto $contractDto): Contract;

    public function updateContract(int $id, ContractDto $contractDto): Contract;

    public function deleteContract(int $id): bool;
}
