<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Exception\FleetNotFoundException;
use Fulll\Domain\Repository\FleetRepositoryInterface;
use Fulll\Infra\Doctrine\ORM\EntityManager;

class FleetRepository extends AbstractRepository implements FleetRepositoryInterface
{
    protected const ENTITY_NAME = Fleet::class;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager->getEntityManager());
    }

    public function getById(string $fleetId): Fleet
    {
        /** @var Fleet|null $fleet */
        $fleet = $this->getRepository()->find($fleetId);

        if (null === $fleet) {
            throw new FleetNotFoundException();
        }

        return $fleet;
    }
}
