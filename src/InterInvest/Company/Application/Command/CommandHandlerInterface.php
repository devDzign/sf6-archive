<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Application\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface CommandHandlerInterface extends MessageHandlerInterface
{
}
