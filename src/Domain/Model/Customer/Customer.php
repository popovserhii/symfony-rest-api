<?php

namespace App\Domain\Model\Customer;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Article
 *
 * @ORM\Entity
 * @package App\Domain\Model\Customer
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="first_name", type="string")
     * @var string
     */
    private $firstName;

    /**
     * @ORM\Column(name="last_name", type="string")
     * @var string
     */
    private $lastName;

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
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @throws \InvalidArgumentException
     */
    public function setFirstName(string $firstName): void
    {
        if (\strlen($firstName) < 2) {
            throw new \InvalidArgumentException('First name needs to have 5 or more characters.');
        }
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}
