<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Domain;

interface Company
{
    public function getId(): int;

    public function getName(): ?string;

    public function setName(string $name): Company;

    public function getLegalStatus(): ?LegalStatus;

    public function setLegalStatus(?LegalStatus $legalCategory): Company;

    public function getSirenNumber(): ?string;

    public function setSirenNumber(string $siren): Company;

    public function getCityOfRegistration(): ?string;

    public function setCityOfRegistration(string $cityOfRegistration): Company;

    public function getDateOfRegistration(): ?\DateTimeImmutable;

    public function setDateOfRegistration(\DateTimeImmutable $dateOfRegistration): Company;

    public function getCapital(): ?string;

    public function setCapital(?string $capital): Company;

    public function getAddresses(): array;

    public function setAddresses(array $addresses): Company;
}
