<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\Application\Command;

use App\InterInvest\Company\Domain\AddressRepositoryInterface;
use App\InterInvest\Company\Domain\CompanyRepositoryInterface;
use App\InterInvest\Company\Domain\LegalStatusRepositoryInterface;
use App\InterInvest\Company\Application\Command\CommandHandlerInterface;

class CreateCompanyCommandHandler implements CommandHandlerInterface
{
    private CompanyRepositoryInterface $companyRepository;
    private LegalStatusRepositoryInterface $legalStatusRepository;
    private AddressRepositoryInterface $addressRepository;

    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        LegalStatusRepositoryInterface $legalStatusRepository,
        AddressRepositoryInterface $addressRepository
    ) {
        $this->companyRepository = $companyRepository;
        $this->legalStatusRepository = $legalStatusRepository;
        $this->addressRepository = $addressRepository;
    }

    public function __invoke(CreateCompanyCommand $command): void
    {
        $this->companyRepository->save(
            $this->companyRepository->new(
                $command->input->name,
                $command->input->sirenNumber,
                $command->input->cityOfRegistration,
                $command->input->dateOfRegistration,
                $command->input->capital,
                $this->legalStatusRepository->findByName($command->input->legalStatus->name),
                array_map(function ($addressInput) {
                    return $this->addressRepository->new(
                        $addressInput->line1,
                        $addressInput->line2,
                        $addressInput->city,
                        $addressInput->postCode
                    );
                }, $command->input->addresses)
            )
        );
    }
}
