<?php

namespace App\Repository;

use App\Entity\LegalCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LegalCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegalCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegalCategories[]    findAll()
 * @method LegalCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegalCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalCategories::class);
    }

    public function add(LegalCategories $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LegalCategories $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
