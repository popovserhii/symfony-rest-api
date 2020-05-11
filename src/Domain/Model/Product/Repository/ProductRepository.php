<?php

namespace App\Domain\Model\Product\Repository;

use App\Domain\Model\Product\Product;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @package App\Infrastructure\Repository
 */
final class ProductRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    /**
     * UserRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Product::class);
    }

    /**
     * @param int $ProductId
     *
     * @return Product
     */
    public function findById(int $ProductId): ?Product
    {
        return $this->objectRepository->find($ProductId);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }

    /**
     * @param Product $Product
     */
    public function save(Product $Product): void
    {
        $this->entityManager->persist($Product);
        $this->entityManager->flush();
    }

    /**
     * @param Product $Product
     */
    public function delete(Product $Product): void
    {
        $this->entityManager->remove($Product);
        $this->entityManager->flush();
    }

}
