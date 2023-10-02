<?php

declare(strict_types=1);

namespace Fulll\Domain\Repository;

use Fulll\Domain\Entity\Vehicle;

interface VehicleRepositoryInterface
{
    public function findOneByFleetIdAndPlateNumber(string $fleetId, string $plateNumber): ?Vehicle;

    public function save(Vehicle $vehicle): void;
}
