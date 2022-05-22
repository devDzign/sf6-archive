<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Domain;

interface LegalStatus
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): LegalStatus;
}
