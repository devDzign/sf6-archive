<?php

declare(strict_types=1);

/**
 * This file is part of a CQRS project interview.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\InterInvest\Company\UI\Web\Controller;

use App\InterInvest\Company\Application\Command\CreateCompanyCommand;
use App\InterInvest\Company\Application\Command\Input\CreateCompanyInput;
use App\InterInvest\Company\UI\Api\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyCreateController extends AbstractController
{
    /**
     * @Route("/", name="company_create")
     */
    public function __invoke(Request $request): Response
    {


        return $this->json('Ready to CQRS...!');
    }
}
