<?php declare(strict_types=1);


namespace App\Controller\v1\Contract;


use App\Controller\v1\BaseController;
use App\Dto\Contract\ContractDto;
use App\Dto\Contract\ContractSearchDto;
use App\Enum\HttpStatusEnum;
use App\Exception\PublicExceptionInterface;
use App\Service\Contract\ContractServiceInterface;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route(path: '/v1/contracts')]
class ContractController extends BaseController implements ContractControllerInterface
{
    private ContractServiceInterface $contractService;

    public function __construct(SerializerInterface $serializer, ContractServiceInterface $contractService)
    {
        parent::__construct($serializer);
        $this->contractService = $contractService;
    }

    #[Route(path: '/', name: 'contracts_all', methods: ['GET'])]
    public function getContractsAction(Request $request): JsonResponse
    {
        /** @var ContractSearchDto $contractSearchDto */
        $contractSearchDto = $request->getContent()
            ? $this->deserialize($request->getContent(),ContractSearchDto::class)
            : new ContractSearchDto();

        try {
            $contracts = $this->contractService->getContracts($contractSearchDto);
        } catch (PublicExceptionInterface $e) {
            return $this->handleException($e);
        }

        $contracts = $this->serialize($contracts);

        return $this->json($contracts);
    }

    #[Route(path: '/{id}', name: 'contract_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getContractAction(int $id): JsonResponse
    {
        try {
            $contract = $this->contractService->getContract($id);
        } catch (PublicExceptionInterface $e) {
            return $this->handleException($e);
        }

        $contract = $this->serialize($contract);

        return $this->json($contract);
    }

    #[Route(path: '/', name: 'contract_store', methods: ['POST'])]
    public function createContractAction(Request $request): JsonResponse
    {
        /** @var ContractDto $data */
        $contractDto = $this->deserialize($request->getContent(), ContractDto::class);

        try {
            $contract = $this->contractService->createContract($contractDto);
        } catch (PublicExceptionInterface $e) {
            return $this->handleException($e);
        }

        $contract = $this->serialize($contract);

        return $this->json($contract, HttpStatusEnum::CREATED->value);
    }

    #[Route(path: '/{id}', name: 'contract_update', requirements: ['id' => '\d+'], methods: ['PUT', 'PATCH'])]
    public function updateContractAction(Request $request, int $id): JsonResponse
    {
        /** @var ContractDto $contractDto */
        $contractDto = $this->deserialize($request->getContent(), ContractDto::class);

        try {
            $contract = $this->contractService->updateContract($id, $contractDto);
        } catch (PublicExceptionInterface $e) {
            return $this->handleException($e);
        }

        $contract = $this->serialize($contract);

        return $this->json($contract, HttpStatusEnum::OK->value);
    }

    #[Route(path: '/{id}', name: 'contract_destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroyContractAction(int $id): JsonResponse
    {
        try {
            $this->contractService->deleteContract($id);
        } catch (PublicExceptionInterface $e) {
            return $this->handleException($e);
        }

        return $this->json(null, HttpStatusEnum::NO_CONTENT->value);
    }
}
