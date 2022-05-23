<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Messenger;

use App\InterInvest\Company\Application\Query\QueryBusInterface;
use App\InterInvest\Company\Application\Query\QueryInterface;
use App\InterInvest\Company\Application\Query\QueryValidationInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\ValidationStamp;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MessengerQueryBus implements QueryBusInterface
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $messageBus;

    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function ask(QueryInterface $query)
    {
        $stamps = [];
        if ($query instanceof QueryValidationInterface) {
            $stamps[] = new ValidationStamp($query->getValidationGroups());
        }

        try {
            $envelope = $this->messageBus->dispatch($query, $stamps);

            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (HandlerFailedException $e) {
            throw $this->unpackException($e);
        }
    }
}
