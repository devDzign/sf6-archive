<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Infrastructure\Doctrine\Entity;

use App\InterInvest\Company\Domain\LegalStatus;
use App\InterInvest\Company\Infrastructure\Doctrine\Persistence\Repository\LegalStatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LegalStatusRepository::class)
 * @ORM\Table(name="legal_status")
 */
class LegalStatusEntity implements LegalStatus, \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): LegalStatusEntity
    {
        $this->name = $name;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
           'name' => $this->name,
       ];
    }
}
