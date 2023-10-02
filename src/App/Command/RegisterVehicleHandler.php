<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\Repository\FleetRepositoryInterface;
use Ramsey\Uuid\Uuid;

class RegisterVehicleHandler
{
    public function __construct(
        private readonly FleetRepositoryInterface $fleetRepository,
    ) {
    }

    public function handle(RegisterVehicle $command): void
    {
        $fleet = $this->fleetRepository->getById($command->fleetId);

        $vehicle = new Vehicle(Uuid::uuid4()->toString(), $command->vehiclePlateNumber);

        $fleet->registerVehicle($vehicle);

        $this->fleetRepository->save($fleet);
    }
}
