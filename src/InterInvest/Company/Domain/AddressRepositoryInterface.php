<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Domain;

interface AddressRepositoryInterface
{
    public function get(int $id): Address;

    public function new(string $line1, ?string $line2, string $city, string $postCode);

    public function all(): iterable;

    public function delete(Address $address): void;
}
