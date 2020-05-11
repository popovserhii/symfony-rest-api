<?php

namespace App\Domain\Model\Customer\Repository;

use App\Domain\Model\Customer\Customer;

/**
 * Interface CustomerRepositoryInterface
 * @package App\Domain\Model\Customer
 */
interface CustomerRepositoryInterface
{
    /**
     * @param int $customerId
     *
     * @return Customer
     */
    public function findById(int $customerId): ?Customer;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param Customer $customer
     */
    public function save(Customer $customer): void;

    /**
     * @param Customer $customer
     */
    public function delete(Customer $customer): void;

}
