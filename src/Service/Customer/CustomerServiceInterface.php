<?php declare(strict_types=1);


namespace App\Service\Customer;


use App\Dto\Customer\CustomerDto;
use App\Dto\Customer\CustomerSearchDto;
use App\Entity\Customer;


interface CustomerServiceInterface
{
    public function getCustomers(CustomerSearchDto $customerSearchDto): array;

    public function getCustomer(int $id): Customer;

    public function createCustomer(CustomerDto $customerDto): Customer;

    public function updateCustomer(int $id, CustomerDto $customerDto): Customer;

    public function deleteCustomer(int $id): bool;
}
