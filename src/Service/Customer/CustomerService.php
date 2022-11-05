<?php declare(strict_types=1);


namespace App\Service\Customer;

use DateTimeImmutable;

use App\Dto\Customer\CustomerDto;
use App\Dto\Customer\CustomerSearchDto;
use App\Entity\Customer;
use App\Exception\NotFoundException;
use App\Exception\ValidationException;
use App\Message\Message\Customer\CustomerCreatedMessage;
use App\Repository\CustomerRepository;
use App\Service\BaseService;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CustomerService extends BaseService implements CustomerServiceInterface
{
    private CustomerRepository $customerRepository;

    private MessageBusInterface $messageBus;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        CustomerRepository $customerRepository,
        MessageBusInterface $messageBus,
    )
    {
        parent::__construct($entityManager, $validator);
        $this->customerRepository = $customerRepository;
        $this->messageBus         = $messageBus;
    }

    /**
     * @param CustomerSearchDto $customerSearchDto Customer search dto
     *
     * @return array
     * @throws ValidationException
     */
    public function getCustomers(CustomerSearchDto $customerSearchDto): array
    {
        $this->validate($customerSearchDto);

        $customers = $this->customerRepository->findBy(
            $customerSearchDto->search,
            $customerSearchDto->order,
            $customerSearchDto->limit,
            $customerSearchDto->offset
        );

        return $customers;
    }

    /**
     * @param int $id Customer id
     *
     * @return Customer
     * @throws NotFoundException
     */
    public function getCustomer(int $id): Customer
    {
        return $this->getCustomerById($id);
    }

    /**
     * @param CustomerDto $customerDto Customer dto
     *
     * @return Customer
     * @throws ValidationException
     */
    public function createCustomer(CustomerDto $customerDto): Customer
    {
        $customer = new Customer();

        $customer->setFirstName($customerDto->firstName);
        $customer->setLastName($customerDto->lastName);
        $customer->setCreatedAt(new DateTimeImmutable());
        $customer->setUpdatedAt(new DateTimeImmutable());

        $this->validate($customer);

        $this->customerRepository->save($customer, true);
        $this->messageBus->dispatch(new CustomerCreatedMessage($customer->getId()));

        return $customer;
    }

    /**
     * @param int         $id          Customer id
     * @param CustomerDto $customerDto Customer dto
     *
     * @return Customer
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function updateCustomer(int $id, CustomerDto $customerDto): Customer
    {
        $customer = $this->getCustomerById($id);

        $customer->setFirstName($customerDto->firstName ?? $customer->getFirstName());
        $customer->setLastName($customerDto->lastName ?? $customer->getLastName());
        $customer->setIsActive($customerDto->isActive ?? $customer->isActive());
        $customer->setUpdatedAt(new DateTimeImmutable());

        $this->validate($customer);
        $this->entityManager->flush();

        return $customer;
    }

    /**
     * @param int $id Customer id
     *
     * @return bool
     * @throws NotFoundException
     */
    public function deleteCustomer(int $id): bool
    {
        $customer = $this->getCustomerById($id);

        $this->customerRepository->remove($customer, true);

        return true;
    }

    /**
     * @param int $id Customer id
     *
     * @return Customer
     * @throws NotFoundException
     */
    private function getCustomerById(int $id): Customer
    {
        $customer = $this->customerRepository->find($id);

        if (!$customer) {
            throw NotFoundException::create(["Customer with 'id' = $id is not found."]);
        }

        return $customer;
    }
}
