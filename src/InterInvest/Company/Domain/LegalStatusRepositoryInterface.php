<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Domain;

interface LegalStatusRepositoryInterface
{
    public function new(string $name): LegalStatus;

    public function get(int $id): LegalStatus;

    public function save(LegalStatus $legalStatus): void;

    public function all(): iterable;

    public function startBulk(int $batchSize = 20): LegalStatusBulkRepositoryInterface;

    public function findByName(string $name): ?LegalStatus;
}
