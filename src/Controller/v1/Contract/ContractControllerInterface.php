<?php declare(strict_types=1);


namespace App\Controller\v1\Contract;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


interface ContractControllerInterface
{
    public function getContractsAction(Request $request): JsonResponse;

    public function getContractAction(int $id): JsonResponse;

    public function createContractAction(Request $request): JsonResponse;

    public function updateContractAction(Request $request, int $id): JsonResponse;

    public function destroyContractAction(int $id): JsonResponse;
}
