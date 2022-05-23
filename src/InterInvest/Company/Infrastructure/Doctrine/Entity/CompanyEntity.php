<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Infrastructure\Doctrine\Entity;

use App\InterInvest\Company\Domain\Company;
use App\InterInvest\Company\Domain\LegalStatus;
use App\InterInvest\Company\Infrastructure\Doctrine\Persistence\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 * @ORM\Table(name="companies")
 */
class CompanyEntity implements Company, \JsonSerializable
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
    private string $name;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $sirenNumber;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $cityOfRegistration;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    private \DateTimeImmutable $dateOfRegistration;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $capital;

    /**
     * @ORM\ManyToOne(targetEntity="App\InterInvest\Company\Infrastructure\Doctrine\Entity\LegalStatusEntity", fetch="EAGER")
     */
    private ?LegalStatus $legalStatus;

    /**
     * @ORM\OneToMany(targetEntity="App\InterInvest\Company\Infrastructure\Doctrine\Entity\AddressEntity", mappedBy="company", cascade={"persist", "remove", "merge"}, fetch="EAGER")
     */
    private Collection $addresses;

    public function __construct(string $name, string $sirenNumber, string $cityOfRegistration, \DateTimeImmutable $dateOfRegistration, string $capital, ?LegalStatus $legalStatus, array $addresses)
    {
        $this->name = $name;
        $this->sirenNumber = $sirenNumber;
        $this->cityOfRegistration = $cityOfRegistration;
        $this->dateOfRegistration = $dateOfRegistration;
        $this->capital = $capital;
        $this->legalStatus = $legalStatus;
        $this->addresses = new ArrayCollection($addresses);
        $this->linkAdresses();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CompanyEntity
    {
        $this->name = $name;

        return $this;
    }

    public function getSirenNumber(): string
    {
        return $this->sirenNumber;
    }

    public function setSirenNumber(string $sirenNumber): CompanyEntity
    {
        $this->sirenNumber = $sirenNumber;

        return $this;
    }

    public function getCityOfRegistration(): string
    {
        return $this->cityOfRegistration;
    }

    public function setCityOfRegistration(string $cityOfRegistration): CompanyEntity
    {
        $this->cityOfRegistration = $cityOfRegistration;

        return $this;
    }

    public function getDateOfRegistration(): \DateTimeImmutable
    {
        return $this->dateOfRegistration;
    }

    public function setDateOfRegistration(\DateTimeImmutable $dateOfRegistration): Company
    {
        $this->dateOfRegistration = $dateOfRegistration;

        return $this;
    }

    public function getCapital(): ?string
    {
        return $this->capital;
    }

    public function setCapital(?string $capital): Company
    {
        $this->capital = $capital;

        return $this;
    }

    public function getLegalStatus(): ?LegalStatus
    {
        return $this->legalStatus;
    }

    public function setLegalStatus(?LegalStatus $legalStatus): CompanyEntity
    {
        $this->legalStatus = $legalStatus;

        return $this;
    }

    public function getAddresses(): array
    {
        return $this->addresses->toArray();
    }

    public function setAddresses(array $addresses): Company
    {
        $this->addresses = new ArrayCollection($addresses);
        $this->linkAdresses();

        return $this;
    }

    private function linkAdresses(): void
    {
        foreach ($this->addresses as $address) {
            $address->setCompany($this);
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'sirenNumber' => $this->sirenNumber,
            'cityOfRegistration' => $this->cityOfRegistration,
            'dateOfRegistration' => $this->dateOfRegistration->format('d-m-Y'),
            'capital' => $this->capital,
            'legalStatus' => $this->legalStatus,
            'addresses' => $this->getAddresses(),
        ];
    }
}
