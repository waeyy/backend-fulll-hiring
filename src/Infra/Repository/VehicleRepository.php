<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\Repository\VehicleRepositoryInterface;
use Fulll\Infra\Doctrine\ORM\EntityManager;

class VehicleRepository extends AbstractRepository implements VehicleRepositoryInterface
{
    protected const ENTITY_NAME = Vehicle::class;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager->getEntityManager());
    }

    public function findOneByFleetIdAndPlateNumber(string $fleetId, string $plateNumber): ?Vehicle
    {
        /* @phpstan-ignore-next-line */
        return $this->getRepository()->findOneBy(['fleet' => $fleetId, 'plateNumber' => $plateNumber]);
    }
}
