<?php

namespace App\EventListener;

use App\Entity\Address;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Services\ArchivedCompany;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ArchivedSubscriber implements EventSubscriber
{

    public function __construct(private ArchivedCompany $archivedCompany, private CompanyRepository $companyRepository, private SerializerInterface $serializer)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::preRemove,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->achivedObject('create', $args);
    }


    public function preRemove(LifecycleEventArgs $args): void
    {
        if (!$args->getObject() instanceof Address) {
            return;
        }

        $this->achivedObject('remove', $args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->achivedObject('update', $args);
    }


    private function achivedObject(string $action, LifecycleEventArgs $args): void
    {
        $object = $args->getObject();

        if (!$object instanceof Company && !$object instanceof Address) {
            return;
        }

        ($object instanceof Address) ?  $this->processAddress($args, $action) : $this->processCompany($args, $action);
    }

    private function processCompany(LifecycleEventArgs $args, string $action): void
    {

        $isCollection = false;
        $companyOld = null;
        $object = $args->getObject();
        $em = $args->getObjectManager();
        /** @var UnitOfWork $uow */
        $uow = $em->getUnitOfWork();

        $changedFields = $uow->getEntityChangeSet($object);


        if ($object instanceof Company && 'create' === $action) {
            $companyOld = clone $object;
        }

        if ($object instanceof Company && is_null($companyOld)) {
            $companyOld = clone $object;
            $fields     = $uow->getEntityChangeSet($object);


            $data = null;
            foreach ($fields as $key => $field) {
                $data[$key] = $field[0];
            }

            $companyOld = $this->serializer->deserialize(
                $this->serializer->serialize($data, 'json'),
                Company::class,
                'json',
                [
                    AbstractNormalizer::OBJECT_TO_POPULATE => $companyOld,
                ]
            );
        }


        $this->archivedCompany->archived($companyOld, $action, ['groups' => 'archived'], $isCollection);
    }

    private function processAddress(LifecycleEventArgs $args, $action): void
    {
        $isCollection = false;
        $object       = $args->getObject();

        $companyOld = null;
        $object = $args->getObject();
        $em = $args->getObjectManager();
        /** @var UnitOfWork $uow */
        $uow = $em->getUnitOfWork();

        if ($object instanceof Address && 'create' === $action) {
            $isCollection = true;
            $action       = 'update';
            $objectClone  = clone $object;
            $companyOld   = $objectClone->getCompany();
            $index        = $companyOld->getLocalizations()->indexOf($object);
            $companyOld->getLocalizations()->remove($index);
        }

        if ($object instanceof Address && 'remove' === $action) {
            $action     = 'update';
            $addressOld = $object;
            $companyOld = $addressOld->getCompany();
        }

        if ($object instanceof Address && is_null($companyOld)) {
            $addressOld   = clone $object;
            $isCollection = true;
            $companyOld   = $addressOld->getCompany();

            $fields = $uow->getEntityChangeSet($object);

            $data = null;
            foreach ($fields as $key => $field) {
                $data[$key] = $field[0];
            }

            $addressOld = $this->serializer->deserialize(
                $this->serializer->serialize($data, 'json'),
                Address::class,
                'json',
                [
                    AbstractObjectNormalizer::OBJECT_TO_POPULATE => $addressOld,
                ]
            );

            $index = $companyOld->getLocalizations()->indexOf($object);
            $companyOld->getLocalizations()->set($index, $addressOld);
        }

        $this->archivedCompany->archived($companyOld, $action, ['groups' => 'archived'], $isCollection);
    }
}
