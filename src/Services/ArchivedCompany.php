<?php

namespace App\Services;

use App\Entity\Archive;
use App\Entity\Company;
use App\Repository\ArchiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ArchivedCompany
{

    public function __construct(
        private ObjectNormalizer $objectNormalizer,
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer
    ) {

    }

    /**
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function archived(Company $company, string $action, array $context = [], bool $isCollection = false): void
    {

        $this->objectNormalizer->setSerializer($this->serializer);

        $archive = (new Archive())
            ->setObjectId($company->getId())
            ->setObjectClass(Company::class)
            ->setAction($action)
            ->setData($this->objectNormalizer->normalize($company, null, $context));

        if ($action === 'update' && $isCollection) {
            $this->entityManager->clear();
        }

        $this->entityManager->persist($archive);
        $this->entityManager->flush();
    }
}
