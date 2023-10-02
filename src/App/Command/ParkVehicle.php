<?php

declare(strict_types=1);

namespace Fulll\App\Command;

class ParkVehicle
{
    public function __construct(
        public readonly string $fleetId,
        public readonly string $vehiclePlateNumber,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
