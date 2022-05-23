<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Infrastructure\Doctrine\Persistence\Repository;

use App\InterInvest\Company\Domain\Company;
use App\InterInvest\Company\Domain\CompanyRepositoryInterface;
use App\InterInvest\Company\Domain\Exception\NotFoundException;
use App\InterInvest\Company\Domain\LegalStatus;
use App\InterInvest\Company\Infrastructure\Doctrine\Entity\CompanyEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CompanyRepository extends ServiceEntityRepository implements CompanyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyEntity::class);
    }

    public function get(int $id): Company
    {
        $company = $this->find($id);
        if (!$company) {
            throw new NotFoundException(Company::class, (string) $id);
        }

        return $company;
    }

    public function new(string $name, string $sirenNumber, string $cityOfRegistration, \DateTimeImmutable $dateOfRegistration, string $capital, LegalStatus $legalStatus, array $addresses): Company
    {
        return new CompanyEntity($name, $sirenNumber, $cityOfRegistration, $dateOfRegistration, $capital, $legalStatus, $addresses);
    }

    public function save(Company $company): void
    {
        $this->getEntityManager()->persist($company);
    }

    public function all(): iterable
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->toIterable();
    }

    public function delete(Company $company): void
    {
        $this->getEntityManager()->remove($company);
    }
}
