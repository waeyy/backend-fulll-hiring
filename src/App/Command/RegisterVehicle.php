<?php

declare(strict_types=1);

namespace Fulll\App\Command;

class RegisterVehicle
{
    public function __construct(
        public readonly string $fleetId,
        public readonly string $vehiclePlateNumber
    ) {
    }
}
