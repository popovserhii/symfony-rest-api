<?php

namespace App\Domain\Model\Voucher;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Article
 *
 * @ORM\Entity
 * @package App\Domain\Model\Voucher
 */
class Voucher
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="code", type="string")
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(name="discount", type="integer")
     * @var int
     */
    private $discount = 0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): Voucher
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }

    /**
     * @param int $discount
     *
     * @throws \InvalidArgumentException
     */
    public function setDiscount(int $discount): Voucher
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return float
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Voucher
     */
    public function setCode(string $code): Voucher
    {
        $this->code = $code;

        return $this;
    }
}
