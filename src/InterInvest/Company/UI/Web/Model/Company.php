<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\UI\Web\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Company
{
    public ?int $id = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $name = null;
    /**
     * @Assert\NotBlank
     */
    public ?string $sirenNumber = null;
    /**
     * @Assert\NotBlank
     */
    public ?string $cityOfRegistration = null;
    /**
     * @@Assert\NotBlank()
     */
    public ?\DateTimeImmutable $dateOfRegistration = null;
    /**
     * @Assert\NotBlank
     */
    public ?string $capital = null;
    /**
     * @Assert\NotBlank
     */
    public ?LegalStatus $legalStatus = null;
    /**
     * @Assert\NotBlank()
     */
    public ?array $addresses = [];

    public function __construct(\App\InterInvest\Company\Domain\Company $company)
    {
        $this->id = $company->getId();
        $this->name = $company->getName();
        $this->sirenNumber = $company->getSirenNumber();
        $this->cityOfRegistration = $company->getCityOfRegistration();
        $this->dateOfRegistration = $company->getDateOfRegistration();
        $this->capital = $company->getCapital();
        $this->legalStatus = new LegalStatus($company->getLegalStatus());
        $this->addresses = array_map(static function ($companyAddress) {
            return new Address($companyAddress);
        }, $company->getAddresses());
    }
}
