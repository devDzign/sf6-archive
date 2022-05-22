<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Domain;

interface Address
{
    public function getId(): int;

    public function getLine1(): string;

    public function setLine1(string $line1): Address;

    public function getLine2(): ?string;

    public function setLine2(?string $line2): Address;

    public function getCity(): string;

    public function setCity(string $city): Address;

    public function getPostCode(): string;

    public function setPostCode(string $postCode): Address;
}
