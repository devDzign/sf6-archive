<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Messenger;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

trait MessageBusExceptionTrait
{
    protected function unpackException(HandlerFailedException $exception): Throwable
    {
        while ($exception instanceof HandlerFailedException) {
            /** @var Throwable $exception */
            $exception = $exception->getPrevious();
        }

        return $exception;
    }
}