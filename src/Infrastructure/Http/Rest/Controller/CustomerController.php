<?php

namespace App\Infrastructure\Http\Rest\Controller;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Model\Customer\Customer;
use App\Application\Service\CustomerService;
use App\Domain\Model\Customer\Repository\CustomerRepository;

/**
 * @package App\Infrastructure\Http\Rest\Controller
 */
final class CustomerController extends AbstractFOSRestController
{
    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * ArticleController constructor.
     *
     * @param CustomerService $userService
     * @param CustomerRepository $userRepository
     */
    public function __construct(CustomerService $userService, CustomerRepository $userRepository)
    {
        $this->customerService = $userService;
        $this->customerRepository = $userRepository;
    }

    /**
     * Creates an Customer resource
     * @Rest\Post("/customers")
     * @param Request $request
     * @return View
     */
    public function postCustomer(Request $request): View
    {
        $user = $this->customerService->addUser($request->get('first_name'), $request->get('last_name'));

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an User resource
     * @Rest\Get("/customers/{customerId}")
     *
     * @param int $customerId
     *
     * @return View
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getCustomer(int $customerId): View
    {
        $customer = $this->customerService->getCustomer($customerId);

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($customer, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of User resource
     * @Rest\Get("/customers")
     * @return View
     */
    public function getCustomers(): View
    {
        $customers = $this->customerService->getAllCustomers();

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
        return View::create($customers, Response::HTTP_OK);
    }
    
    /**
     * Replaces Article resource
     * @Rest\Put("/customers/{customerId}")
     *
     * @param int $customerId
     *
     * @return View
     */
    public function putCustomer(int $customerId, Request $request): View
    {
        $user = $this->customerService->updateCustomer($customerId, $request->get('first_name'), $request->get('last_name'));

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return View::create($user, Response::HTTP_OK);
    }

    /**
     * Removes the User resource
     *
     * @Rest\Delete("/customers/{customerId}")
     *
     * @param int $customerId
     * @return View
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function deleteArticle(int $customerId): View
    {
        $this->customerService->deleteUser($customerId);

        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
