<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Infrastructure\Doctrine\Entity;

use App\InterInvest\Company\Domain\Address;
use App\InterInvest\Company\Domain\Company;
use App\InterInvest\Company\Infrastructure\Doctrine\Persistence\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 * @ORM\Table(name="addresses")
 */
class AddressEntity implements Address, \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $line1;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $line2;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $city;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $postCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\InterInvest\Company\Infrastructure\Doctrine\Entity\CompanyEntity", inversedBy="addresses", fetch="EAGER")
     */
    private Company $company;

    public function __construct(string $line1, ?string $line2, string $city, string $postCode)
    {
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->city = $city;
        $this->postCode = $postCode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): AddressEntity
    {
        $this->id = $id;

        return $this;
    }

    public function getLine1(): string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): AddressEntity
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(?string $line2): AddressEntity
    {
        $this->line2 = $line2;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): AddressEntity
    {
        $this->city = $city;

        return $this;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): AddressEntity
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): AddressEntity
    {
        $this->company = $company;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'line1' => $this->line1,
            'line2' => $this->line2,
            'city' => $this->city,
            'postCode' => $this->postCode,
       ];
    }
}
