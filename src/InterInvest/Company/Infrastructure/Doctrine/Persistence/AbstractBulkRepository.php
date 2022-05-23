<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Infrastructure\Doctrine\Persistence;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractBulkRepository
{
    private EntityManagerInterface $entityManager;

    private int $batchSize;

    private ?string $entityName;

    private int $count = 0;

    public function __construct(EntityManagerInterface $entityManager, int $batchSize, ?string $entityName = null)
    {
        $this->entityManager = $entityManager;
        $this->batchSize = $batchSize;
        $this->entityName = $entityName;
    }

    protected function increment(): void
    {
        ++$this->count;
        if ($this->count >= $this->batchSize) {
            $this->flush();
        }
    }

    public function end(): void
    {
        $this->flush();
    }

    private function flush(): void
    {
        $this->entityManager->flush();
        $this->entityManager->clear($this->entityName);
        $this->count = 0;
    }
}
