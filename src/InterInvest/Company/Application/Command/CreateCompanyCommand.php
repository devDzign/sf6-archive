<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Application\Command;

use App\InterInvest\Company\Application\Command\Input\CreateCompanyInput;
use App\InterInvest\Company\Application\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCompanyCommand implements CommandInterface
{
    /**
     * @Assert\Valid
     */
    public ?CreateCompanyInput $input;

    public function __construct(CreateCompanyInput $input)
    {
        $this->input = $input;
    }
}
