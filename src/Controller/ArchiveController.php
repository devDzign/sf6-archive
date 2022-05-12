<?php

namespace App\Controller;

use App\Entity\Archive;
use App\Entity\Company;
use App\Repository\ArchiveRepository;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/company')]
class ArchiveController extends AbstractController
{

    public function __construct(private ArchiveRepository $archiveRepository,private CompanyRepository $companyRepository)
    {
    }

    #[Route('/{id}/archive', name: 'archive')]
    public function index(int $id): Response
    {
        return $this->render("archive/index.html.twig", [
           "companyOrigin" => $this->companyRepository->find($id),
           "archives" => $this->archiveRepository->findAllArchivesForCompany(Company::class, $id)
        ]);
    }

    #[Route('/{id}/archive/{id_archive}', name: 'detail_archive')]
    /**
     * @ParamConverter("archive", options={"id" = "id_archive"})
     */
    public function details(int $id, Archive $archive): Response
    {
        return $this->render("archive/detail.html.twig", [
            "companyOrigin" => $this->companyRepository->find($id),
            "archive" => $archive
        ]);
    }
}
