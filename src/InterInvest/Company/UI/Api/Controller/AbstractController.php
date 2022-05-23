<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\UI\Api\Controller;

use App\InterInvest\Company\Application\Command\CommandBusInterface;
use App\InterInvest\Company\Form\InputForm;
use App\InterInvest\Company\Application\Query\QueryBusInterface;
use App\InterInvest\Company\Application\Command\CommandInterface;
use App\InterInvest\Company\Application\Input\InputInterface;
use App\InterInvest\Company\Application\Query\QueryInterface;
use App\InterInvest\Company\Domain\Exception\ConflictException;
use App\InterInvest\Company\Domain\Exception\Exception;
use App\InterInvest\Company\Domain\Exception\LockedException;
use App\InterInvest\Company\Domain\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseAbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class AbstractController extends BaseAbstractController
{

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }


    protected function handle(CommandInterface $command)
    {
        try {
            return $this->commandBus->handle($command);
        } catch (NotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage(), $exception, $exception->getCode());
        } catch (LockedException $exception) {
            throw new HttpException(Response::HTTP_LOCKED, $exception->getMessage(), $exception, [], $exception->getCode());
        } catch (ConflictException $exception) {
            throw new ConflictHttpException($exception->getMessage(), $exception, $exception->getCode());
        } catch (Exception $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception, $exception->getCode());
        }
    }
}
