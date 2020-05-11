<?php

namespace App\Domain\Model\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Article
 *
 * @ORM\Entity
 * @package App\Domain\Model\Product
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="price", type="float")
     * @var float
     */
    private $price = 0.0;

    /**
     * @ORM\Column(name="price_with_discount", type="float")
     * @var float
     */
    private $priceWithDiscount = 0.0;

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
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     *
     * @throws \InvalidArgumentException
     */
    public function setPrice(string $price): void
    {
        if (\strlen($price) < 2) {
            throw new \InvalidArgumentException('First name needs to have 5 or more characters.');
        }
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPriceWithDiscount(): float
    {
        return $this->priceWithDiscount;
    }

    /**
     * @param float $priceWithDiscount
     *
     * @return Product
     */
    public function setPriceWithDiscount(float $priceWithDiscount): Product
    {
        $this->priceWithDiscount = $priceWithDiscount;

        return $this;
    }
}
