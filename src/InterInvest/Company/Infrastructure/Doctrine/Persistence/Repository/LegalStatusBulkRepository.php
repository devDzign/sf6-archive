<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Infrastructure\Doctrine\Persistence\Repository;

use App\InterInvest\Company\Domain\LegalStatus;
use App\InterInvest\Company\Domain\LegalStatusBulkRepositoryInterface;
use App\InterInvest\Company\Domain\LegalStatusRepositoryInterface;
use App\InterInvest\Company\Infrastructure\Doctrine\Entity\LegalStatusEntity;
use App\InterInvest\Company\Infrastructure\Doctrine\Persistence\AbstractBulkRepository;
use Doctrine\ORM\EntityManagerInterface;

class LegalStatusBulkRepository extends AbstractBulkRepository implements LegalStatusBulkRepositoryInterface
{
    private LegalStatusRepositoryInterface $legalStatusRepository;

    public function __construct(EntityManagerInterface $entityManager, int $batchSize, LegalStatusRepositoryInterface $legalStatusRepository)
    {
        parent::__construct($entityManager, $batchSize, LegalStatusEntity::class);

        $this->legalStatusRepository = $legalStatusRepository;
    }

    public function save(LegalStatus $line): void
    {
        $this->legalStatusRepository->save($line);
        $this->increment();
    }
}
