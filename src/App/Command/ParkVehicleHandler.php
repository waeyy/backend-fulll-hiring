<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\Exception\VehicleNotFoundException;
use Fulll\Domain\Repository\VehicleRepositoryInterface;
use Fulll\Domain\ValueObject\Location;

class ParkVehicleHandler
{
    public function __construct(private readonly VehicleRepositoryInterface $vehicleRepository)
    {
    }

    public function handle(ParkVehicle $command): void
    {
        $vehicle = $this->vehicleRepository->findOneByFleetIdAndPlateNumber(
            $command->fleetId,
            $command->vehiclePlateNumber
        );

        if (null === $vehicle) {
            throw new VehicleNotFoundException();
        }

        $vehicle->park(new Location($command->latitude, $command->longitude));

        $this->vehicleRepository->save($vehicle);
    }
}
