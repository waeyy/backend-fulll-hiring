<?php

declare(strict_types=1);

namespace Fulll\Domain\Repository;

use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Exception\FleetNotFoundException;

interface FleetRepositoryInterface
{
    /**
     * @throws FleetNotFoundException
     */
    public function getById(string $fleetId): Fleet;

    public function save(Fleet $fleet): void;
}
