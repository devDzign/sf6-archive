<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Application\Command\Input;

use App\InterInvest\Company\UI\Web\Model\LegalStatus;
use App\InterInvest\Company\Application\Input\InputInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCompanyInput implements InputInterface
{
    /**
     * @Assert\NotBlank
     */
    public ?string $name = null;
    /**
     * @Assert\NotBlank
     */
    public ?string $sirenNumber = null;
    /**
     * @Assert\NotBlank
     */
    public ?string $cityOfRegistration = null;
    /**
     * @@Assert\NotBlank()
     */
    public ?\DateTimeImmutable $dateOfRegistration = null;
    /**
     * @Assert\NotBlank
     */
    public ?string $capital = null;
    /**
     * @Assert\NotBlank
     */
    public ?LegalStatus $legalStatus = null;

    public ?array $addresses = [];
}
