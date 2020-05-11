<?php

namespace App\Application\Service;

use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\Repository\ProductRepository;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @package App\Application\Service
 */
final class ProductService
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param ProductRepository $userRepository
     */
    public function __construct(ProductRepository $userRepository)
    {
        $this->productRepository = $userRepository;
    }

    /**
     * @param int $customerId
     *
     * @return Product
     * @throws EntityNotFoundException
     */
    public function getProduct(int $customerId): Product
    {
        $customer = $this->productRepository->findById($customerId);
        if (!$customer) {
            throw new EntityNotFoundException('Product with id ' . $customerId . ' does not exist!');
        }

        return $customer;
    }

    /**
     * @return array|null
     */
    public function getAllProducts(): ?array
    {
        return $this->productRepository->findAll();
    }

    /**
     * @param float $price
     * @param float $priceWithDiscount
     *
     * @return Product
     */
    public function addUser(float $price, float $priceWithDiscount): Product
    {
        $product = new Product();
        $product->setPrice($price);
        $product->setPriceWithDiscount($priceWithDiscount);
        $this->productRepository->save($product);

        return $product;
    }

    /**
     * @param int $userId
     * @param float $price
     * @param float $priceWithDiscount
     *
     * @return Product
     * @throws EntityNotFoundException
     */
    public function updateProduct(int $userId, float $price, float $priceWithDiscount): Product
    {
        $product = $this->productRepository->findById($userId);
        if (!$product) {
            throw new EntityNotFoundException('Product with id ' . $userId . ' does not exist!');
        }
        $product = new Product();
        $product->setPrice($price);
        $product->setPriceWithDiscount($priceWithDiscount);
        $this->productRepository->save($product);

        return $product;
    }

    /**
     * @param int $productId
     *
     * @throws EntityNotFoundException
     */
    public function deleteProduct(int $productId): void
    {
        $user = $this->productRepository->findById($productId);
        if (!$user) {
            throw new EntityNotFoundException('Product with id ' . $productId . ' does not exist!');
        }
        $this->productRepository->delete($user);
    }
}
