<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Application\Command\Input;

use Symfony\Component\Validator\Constraints as Assert;

class AddressInput
{
    /**
     * @Assert\NotBlank
     */
    public ?int $id = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $line1 = null;

    public ?string $line2 = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $city = null;

    /**
     * @Assert\NotBlank
     */
    public ?string $postCode = null;
}
