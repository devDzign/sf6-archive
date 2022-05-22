<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\UI\Web\Model;

use App\InterInvest\Company\Domain\Address as DomainAddress;
use Symfony\Component\Validator\Constraints as Assert;

class Address
{
    public ?int $id = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $line1 = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $line2 = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $city = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $postCode = null;

    public function __construct(DomainAddress $address)
    {
        $this->id = $address->getId();
        $this->line1 = $address->getLine1();
        $this->line2 = $address->getLine2();
        $this->city = $address->getCity();
        $this->postCode = $address->getPostCode();
    }
}
