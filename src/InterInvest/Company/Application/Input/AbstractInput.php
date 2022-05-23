<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Application\Input;

abstract class AbstractInput implements InputInterface
{
    /**
     * @var array<string>
     */
    private array $submittedKeys = [];

    public function hasSubmit(string $name): bool
    {
        return in_array($name, $this->submittedKeys);
    }

    /**
     * @param array<string> $submittedKeys
     */
    public function setSubmittedKeys(array $submittedKeys): void
    {
        $this->submittedKeys = $submittedKeys;
    }

    public function addSubmittedKey(string $key): void
    {
        $this->submittedKeys[] = $key;
    }
}
