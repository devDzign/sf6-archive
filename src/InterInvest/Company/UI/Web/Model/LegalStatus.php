<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\UI\Web\Model;

use Symfony\Component\Validator\Constraints as Assert;

class LegalStatus
{
    public ?int $id;
    /**
     * @Assert\NotBlank
     */
    public string $name;

    public function __construct(\App\InterInvest\Company\Domain\LegalStatus $legalStatus)
    {
        $this->id = $legalStatus->getId();
        $this->name = $legalStatus->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): LegalStatus
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): LegalStatus
    {
        $this->name = $name;

        return $this;
    }
}
