<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Messenger;

use App\InterInvest\Company\Application\Event\EventBusInterface;
use App\InterInvest\Company\Application\Event\EventInterface;
use App\InterInvest\Company\Messenger\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerEventBus implements EventBusInterface
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function handle(EventInterface $event): void
    {
        try {
            $this->messageBus->dispatch($event);
        } catch (HandlerFailedException $e) {
            throw $this->unpackException($e);
        }
    }
}
