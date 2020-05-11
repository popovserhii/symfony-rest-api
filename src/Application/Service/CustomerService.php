<?php

namespace App\Application\Service;

use App\Domain\Model\Customer\Customer;
use App\Domain\Model\Customer\Repository\CustomerRepository;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @package App\Application\Service
 */
final class CustomerService
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * CustomerService constructor.
     *
     * @param CustomerRepository $userRepository
     */
    public function __construct(CustomerRepository $userRepository)
    {
        $this->customerRepository = $userRepository;
    }

    /**
     * @param int $customerId
     *
     * @return Customer
     * @throws EntityNotFoundException
     */
    public function getCustomer(int $customerId): Customer
    {
        $customer = $this->customerRepository->findById($customerId);
        if (!$customer) {
            throw new EntityNotFoundException('User with id ' . $customerId . ' does not exist!');
        }

        return $customer;
    }

    /**
     * @return array|null
     */
    public function getAllCustomers(): ?array
    {
        return $this->customerRepository->findAll();
    }

    /**
     * @param string $firstName
     * @param string $lastName
     *
     * @return Customer
     */
    public function addUser(string $firstName, string $lastName): Customer
    {
        $user = new Customer();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $this->customerRepository->save($user);

        return $user;
    }

    /**
     * @param int $userId
     * @param string $firstName
     * @param string $lastName
     *
     * @return Customer
     * @throws EntityNotFoundException
     */
    public function updateCustomer(int $userId, string $firstName, string $lastName): Customer
    {
        $user = $this->customerRepository->findById($userId);
        if (!$user) {
            throw new EntityNotFoundException('User with id ' . $userId . ' does not exist!');
        }
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $this->customerRepository->save($user);

        return $user;
    }

    /**
     * @param int $userId
     *
     * @throws EntityNotFoundException
     */
    public function deleteUser(int $userId): void
    {
        $user = $this->customerRepository->findById($userId);
        if (!$user) {
            throw new EntityNotFoundException('User with id ' . $userId . ' does not exist!');
        }
        $this->customerRepository->delete($user);
    }
}
