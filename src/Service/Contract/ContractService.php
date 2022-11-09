<?php

declare(strict_types=1);

namespace App\Service\Contract;

use App\Dto\Contract\ContractDto;
use App\Dto\Contract\ContractSearchDto;
use App\Entity\Contract;
use App\Exception\NotFoundException;
use App\Exception\ValidationException;
use App\Repository\ContractRepository;
use App\Service\BaseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContractService extends BaseService implements ContractServiceInterface
{
    private ContractRepository $contractRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        ContractRepository $contractRepository,
    ) {
        parent::__construct($entityManager, $validator);
        $this->contractRepository = $contractRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function getContracts(ContractSearchDto $contractSearchDto): array
    {
        $this->validate($contractSearchDto);

        return $this->contractRepository->findBy(
            $contractSearchDto->search,
            $contractSearchDto->order,
            $contractSearchDto->limit,
            $contractSearchDto->offset
        );
    }

    /**
     * @param int $id Contract id
     *
     * @throws NotFoundException
     */
    public function getContract(int $id): Contract
    {
        return $this->getContractById($id);
    }

    /**
     * @param ContractDto $contractDto Contract dto
     *
     * @throws ValidationException
     */
    public function createContract(ContractDto $contractDto): Contract
    {
        $this->validate($contractDto, ['new']);

        $contract = new Contract();

        $contract->setNumber($contractDto->number);
        $contract->setStartDate($contractDto->startDate);
        $contract->setFinishDate($contractDto->finishDate);
        $contract->setName($contractDto->name);
        $contract->setCreatedAt(new \DateTimeImmutable());
        $contract->setUpdatedAt(new \DateTimeImmutable());

        $this->contractRepository->save($contract, true);

        return $contract;
    }

    public function testTest(ContractDto $contractDto): ContractDto
    {
        return $contractDto;
    }

    /**
     * @param int         $id          Contract id
     * @param ContractDto $contractDto Contract dto
     *
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function updateContract(int $id, ContractDto $contractDto): Contract
    {
        $this->validate($contractDto, ['update']);

        $contract = $this->getContractById($id);

        $contract->setNumber($contractDto->number ?? $contract->getNumber());
        $contract->setStartDate($contractDto->startDate ?? $contract->getStartDate());
        $contract->setFinishDate($contractDto->isActive ?? $contract->getFinishDate());
        $contract->setName($contractDto->name ?? $contract->getName());
        $contract->setUpdatedAt(new \DateTimeImmutable());

        $this->validate($contract);
        $this->entityManager->flush();

        return $contract;
    }

    /**
     * @param int $id Contract id
     *
     * @throws NotFoundException
     */
    public function deleteContract(int $id): bool
    {
        $contract = $this->getContractById($id);

        $this->contractRepository->remove($contract, true);

        return true;
    }

    /**
     * @param int $id Contract id
     *
     * @throws NotFoundException
     */
    private function getContractById(int $id): ?Contract
    {
        $contract = $this->contractRepository->find($id);

        if (!$contract) {
            return null;
        }

        return $contract;
    }
}
