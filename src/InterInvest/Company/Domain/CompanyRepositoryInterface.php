<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Domain;

interface CompanyRepositoryInterface
{
    public function get(int $id): Company;

    public function new(
        string $name,
        string $sirenNumber,
        string $cityOfRegistration,
        \DateTimeImmutable $dateOfRegistration,
        string $capital,
        LegalStatus $legalStatus,
        array $addresses
    ): Company;

    public function save(Company $company);

    public function all(): iterable;

    public function delete(Company $company): void;
}
