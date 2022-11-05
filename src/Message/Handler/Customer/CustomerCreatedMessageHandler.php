<?php declare(strict_types=1);


namespace App\Message\Handler\Customer;


use App\Message\Message\Customer\CustomerCreatedMessage;
use App\Repository\CustomerRepository;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler]
class CustomerCreatedMessageHandler
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function __invoke(CustomerCreatedMessage $customerCreatedMessage): void
    {
        $customer = $this->customerRepository->find($customerCreatedMessage->getCreatedCustomerId());

        echo json_encode([
            'id'        => $customer->getId(),
            'firstName' => $customer->getFirstName(),
            'lastName'  => $customer->getLastName(),
            'createdAt' => $customer->getCreatedAt(),
            'updatedAt' => $customer->getUpdatedAt(),
        ]) . "\n";
    }
}
