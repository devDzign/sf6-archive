<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Infrastructure\Doctrine\Persistence\Repository;

use App\InterInvest\Company\Domain\Address;
use App\InterInvest\Company\Domain\AddressRepositoryInterface;
use App\InterInvest\Company\Infrastructure\Doctrine\Entity\AddressEntity;
use App\InterInvest\Company\Domain\Exception\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AddressRepository extends ServiceEntityRepository implements AddressRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddressEntity::class);
    }

    public function new(string $line1, ?string $line2, string $city, string $postCode)
    {
        return new AddressEntity($line1, $line2, $city, $postCode);
    }

    public function get(int $id): Address
    {
        $address = $this->find($id);
        if (!$address) {
            throw new NotFoundException(Address::class, (string) $id);
        }

        return $address;
    }

    public function all(): iterable
    {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->toIterable();
    }

    public function delete(Address $address): void
    {
        $this->getEntityManager()->remove($address);
    }
}
