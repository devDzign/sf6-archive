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
use App\InterInvest\Shared\Domain\Exception\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LegalStatusRepository extends ServiceEntityRepository implements LegalStatusRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalStatusEntity::class);
    }

    public function new(string $name): LegalStatus
    {
        return new LegalStatusEntity($name);
    }

    public function get(int $id): LegalStatus
    {
        $company = $this->find($id);
        if (!$company) {
            throw new NotFoundException(LegalStatus::class, (string) $id);
        }

        return $company;
    }

    public function save(LegalStatus $legalStatus): void
    {
        $this->_em->persist($legalStatus);
    }

    public function all(): iterable
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->toIterable();
    }

    public function startBulk(int $batchSize = 20): LegalStatusBulkRepositoryInterface
    {
        return new LegalStatusBulkRepository($this->_em, $batchSize, $this);
    }

    public function findByName(string $name): ?LegalStatus
    {
        return $this->createQueryBuilder('legal_status')
            ->where('legal_status.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
