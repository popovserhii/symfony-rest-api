<?php

namespace App\Application\Service;

use App\Domain\Model\Voucher\Voucher;
use App\Domain\Model\Voucher\Repository\VoucherRepository;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @package App\Application\Service
 */
final class VoucherService
{
    /**
     * @var VoucherRepository
     */
    private $voucherRepository;

    /**
     * @param VoucherRepository $voucherRepository
     */
    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    /**
     * @param int $customerId
     *
     * @return Voucher
     * @throws EntityNotFoundException
     */
    public function getVoucher(int $customerId): Voucher
    {
        $customer = $this->voucherRepository->findById($customerId);
        if (!$customer) {
            throw new EntityNotFoundException('Voucher with id ' . $customerId . ' does not exist!');
        }

        return $customer;
    }

    /**
     * @return array|null
     */
    public function getAllVouchers(): ?array
    {
        return $this->voucherRepository->findAll();
    }

    /**
     * @param int $discount
     *
     * @return Voucher
     */
    public function generateVoucher(int $discount): Voucher
    {
        $code = $this->generateUniqCode();

        $voucher = new Voucher();
        $voucher->setCode($code);
        $voucher->setDiscount($discount);
        $this->voucherRepository->save($voucher);

        return $voucher;
    }
    /**
     * @param array $items
     * @param string $code
     *
     * @return array
     */
    public function applyVoucher(array $items, string $code): array
    {
        /** @var Voucher $voucher */
        $voucher = $this->voucherRepository->findByCode($code);

        $items = $this->calculatePrices($voucher, $items);

        return ['items' => $items, 'code'=> $voucher->getCode()];
    }

    protected function calculatePrices(Voucher $voucher, $items)
    {
        $maxPrice = 0;
        $totalPrice = 0;
        foreach ($items as $item) {
            $totalPrice += $item['price'];
            if ($item['price'] > $maxPrice) {
                $maxPrice = $item['price'];
            }
        }

        $discount = $voucher->getDiscount();
        if ($discount > $totalPrice) {
            $discount = $totalPrice;
        }

        foreach ($items as & $item) {
            $totalPercent = ($discount / $totalPrice);
            $newPrice = ($item['price'] - ($item['price'] * $totalPercent));
            $item['price_with_discount'] = number_format((float) $newPrice, 2, '.', '');
        }

        return $items;
    }

    /**
     * @param int $voucherId
     * @param int $discount
     *
     * @return Voucher
     * @throws EntityNotFoundException
     */
    public function updateVoucher(int $voucherId, int $discount): Voucher
    {
        $voucher = $this->voucherRepository->findById($voucherId);
        if (!$voucher) {
            throw new EntityNotFoundException('Voucher with id ' . $voucherId . ' does not exist!');
        }
        $voucher->setDiscount($discount);
        $this->voucherRepository->save($voucher);

        return $voucher;
    }

    /**
     * @param int $productId
     *
     * @throws EntityNotFoundException
     */
    public function deleteVoucher(int $productId): void
    {
        $user = $this->voucherRepository->findById($productId);
        if (!$user) {
            throw new EntityNotFoundException('Voucher with id ' . $productId . ' does not exist!');
        }
        $this->voucherRepository->delete($user);
    }

    public function generateUniqCode()
    {
        return mb_strtoupper(substr(md5(uniqid(rand(), true)), 0, 9));
    }
}
