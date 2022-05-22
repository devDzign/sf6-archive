<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\UI\Api\Controller;

use App\InterInvest\Shared\Application\Command\CommandBusInterface;
use App\InterInvest\Shared\Application\Command\CommandInterface;
use App\InterInvest\Shared\Application\Input\InputInterface;
use App\InterInvest\Shared\Application\Query\QueryBusInterface;
use App\InterInvest\Shared\Application\Query\QueryInterface;
use App\InterInvest\Shared\Domain\Exception\ConflictException;
use App\InterInvest\Shared\Domain\Exception\Exception;
use App\InterInvest\Shared\Domain\Exception\LockedException;
use App\InterInvest\Shared\Domain\Exception\NotFoundException;
use App\InterInvest\Shared\Form\InputForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseAbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class AbstractController extends BaseAbstractController
{
    private QueryBusInterface $queryBus;

    private CommandBusInterface $commandBus;

    private InputForm $inputForm;

    public function __construct(QueryBusInterface $queryBus, CommandBusInterface $commandBus, InputForm $inputForm)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
        $this->inputForm = $inputForm;
    }

    protected function submitInput(?InputInterface $input, string $type, array $data, array $options = []): InputInterface
    {
        return $this->inputForm->submit($input, $type, $data, $options);
    }

    protected function submitBulkInput(string $type, array $data, array $options = []): array
    {
        return $this->inputForm->submitBulk($type, $data, $options);
    }

    protected function ask(QueryInterface $query)
    {
        try {
            return $this->queryBus->ask($query);
        } catch (NotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage(), $exception);
        } catch (Exception $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }
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
