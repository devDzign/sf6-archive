<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Messenger;

use App\InterInvest\Company\Application\Command\CommandBusInterface;
use App\InterInvest\Company\Application\Command\CommandInterface;
use App\InterInvest\Company\Application\Command\CommandValidationInterface;
use App\InterInvest\Company\Messenger\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\ValidationStamp;

class MessengerCommandBus implements CommandBusInterface
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function handle(CommandInterface $command)
    {
        $stamps = [];
        if ($command instanceof CommandValidationInterface) {
            $stamps[] = new ValidationStamp($command->getValidationGroups());
        }

        try {
            $envelope = $this->messageBus->dispatch($command, $stamps);

            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (HandlerFailedException $e) {
            throw $this->unpackException($e);
        }
    }
}
