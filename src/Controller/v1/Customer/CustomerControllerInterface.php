<?php declare(strict_types=1);


namespace App\Controller\v1\Customer;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


interface CustomerControllerInterface
{
    public function getCustomersAction(Request $request): JsonResponse;

    public function getCustomerAction(int $id): JsonResponse;

    public function createCustomerAction(Request $request): JsonResponse;

    public function updateCustomerAction(Request $request, int $id): JsonResponse;

    public function destroyCustomerAction(int $id): JsonResponse;
}
