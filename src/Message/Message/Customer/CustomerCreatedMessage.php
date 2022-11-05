<?php declare(strict_types=1);


namespace App\Message\Message\Customer;


use App\Message\Message\BaseMessage;


class CustomerCreatedMessage extends BaseMessage
{
    private int $customerId;

    public function __construct(int $customerId)
    {
        $this->customerId = $customerId;
    }

    public function getCreatedCustomerId(): int
    {
        return $this->customerId;
    }
}
