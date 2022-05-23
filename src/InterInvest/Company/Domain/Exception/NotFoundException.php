<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Domain\Exception;

use ReflectionClass;

class NotFoundException extends Exception
{
    private string $class;

    private string $id;

    private string $field;

    public function __construct(string $class, string $id, string $field = 'id')
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        $shortName = (new ReflectionClass($class))->getShortName();

        parent::__construct("Not found $shortName with $field '$id'");
        $this->class = $class;
        $this->id = $id;
        $this->field = $field;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getField(): string
    {
        return $this->field;
    }
}
