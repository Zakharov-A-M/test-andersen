<?php declare(strict_types=1);


namespace App\Controller\v1\Customer;


use App\Controller\v1\BaseController;
use App\Dto\Customer\CustomerDto;
use App\Dto\Customer\CustomerSearchDto;
use App\Enum\HttpStatusEnum;
use App\Exception\PublicExceptionInterface;
use App\Service\Customer\CustomerServiceInterface;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route(path: '/v1/customers')]
class CustomerController extends BaseController implements CustomerControllerInterface
{
    private CustomerServiceInterface $customerService;

    public function __construct(SerializerInterface $serializer, CustomerServiceInterface $customerService)
    {
        parent::__construct($serializer);
        $this->customerService = $customerService;
    }

    #[Route(path: '/', name: 'customer_all', methods: ['GET'])]
    public function getCustomersAction(Request $request): JsonResponse
    {
        /** @var CustomerSearchDto $customerSearchDto */
        $customerSearchDto = $request->getContent()
            ? $this->deserialize($request->getContent(),CustomerSearchDto::class)
            : new CustomerSearchDto();

        try {
            $customers = $this->customerService->getCustomers($customerSearchDto);
        } catch (PublicExceptionInterface $e) {
            return $this->handleException($e);
        }

        $customers = $this->serialize($customers);

        return $this->json($customers);
    }

    #[Route(path: '/{id}', name: 'customer_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getCustomerAction(int $id): JsonResponse
    {
        try {
            $customer = $this->customerService->getCustomer($id);
        } catch (PublicExceptionInterface $e) {
            return $this->handleException($e);
        }

        $customer = $this->serialize($customer);

        return $this->json($customer);
    }

    #[Route(path: '/', name: 'customer_store', methods: ['POST'])]
    public function createCustomerAction(Request $request): JsonResponse
    {
        /** @var CustomerDto $data */
        $customerDto = $this->deserialize($request->getContent(), CustomerDto::class);

        try {
            $customer = $this->customerService->createCustomer($customerDto);
        } catch (PublicExceptionInterface $e) {
            return $this->handleException($e);
        }

        $customer = $this->serialize($customer);

        return $this->json($customer, HttpStatusEnum::CREATED->value);
    }

    #[Route(path: '/{id}', name: 'customer_update', requirements: ['id' => '\d+'], methods: ['PUT', 'PATCH'])]
    public function updateCustomerAction(Request $request, int $id): JsonResponse
    {
        /** @var CustomerDto $customerDto */
        $customerDto = $this->deserialize($request->getContent(), CustomerDto::class);

        try {
            $customer = $this->customerService->updateCustomer($id, $customerDto);
        } catch (PublicExceptionInterface $e) {
            return $this->handleException($e);
        }

        $customer = $this->serialize($customer);

        return $this->json($customer, HttpStatusEnum::OK->value);
    }

    #[Route(path: '/{id}', name: 'customer_destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroyCustomerAction(int $id): JsonResponse
    {
        try {
            $this->customerService->deleteCustomer($id);
        } catch (PublicExceptionInterface $e) {
            return $this->handleException($e);
        }

        return $this->json(null, HttpStatusEnum::NO_CONTENT->value);
    }
}
