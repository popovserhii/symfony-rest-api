<?php

namespace App\Domain\Model\Voucher\Repository;

use App\Domain\Model\Voucher\Voucher;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @package App\Infrastructure\Repository
 */
final class VoucherRepository
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
        $this->objectRepository = $this->entityManager->getRepository(Voucher::class);
    }

    /**
     * @param int $voucherId
     *
     * @return Voucher
     */
    public function findById(int $voucherId): ?Voucher
    {
        return $this->objectRepository->find($voucherId);
    }

    public function findByCode(string $code): ?Voucher
    {
        return $this->objectRepository->findOneBy(['code' => $code]);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }

    /**
     * @param Voucher $voucher
     */
    public function save(Voucher $voucher): void
    {
        $this->entityManager->persist($voucher);
        $this->entityManager->flush();
    }

    /**
     * @param Voucher $voucher
     */
    public function delete(Voucher $voucher): void
    {
        $this->entityManager->remove($voucher);
        $this->entityManager->flush();
    }

}
