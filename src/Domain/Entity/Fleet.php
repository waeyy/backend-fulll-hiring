<?php

declare(strict_types=1);

namespace Fulll\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Fulll\Domain\Exception\VehicleAlreadyRegisteredException;

#[ORM\Entity]
class Fleet
{
    /** @var Collection<Vehicle> */
    #[ORM\OneToMany(
        mappedBy: 'fleet',
        targetEntity: Vehicle::class,
        cascade: ['persist', 'remove']
    )]
    public Collection $vehicles;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string', length: 36)]
        public string $id,
        #[ORM\Column(type: 'string', length: 36)]
        public string $userId,
    ) {
        $this->vehicles = new ArrayCollection();
    }

    public function registerVehicle(Vehicle $vehicle): void
    {
        /** @phpstan-ignore-next-line */
        $isVehicleRegistered = $this->vehicles->exists(function (int $key, Vehicle $vehicleRegistered) use ($vehicle) {
            return $vehicleRegistered->plateNumber === $vehicle->plateNumber;
        });

        if (true === $isVehicleRegistered) {
            // phpcs:ignore
            throw new VehicleAlreadyRegisteredException(sprintf("Vehicle licensed '%d' is already registered into the fleet.", $vehicle->plateNumber));
        }

        $vehicle->fleet = $this;

        $this->vehicles->add($vehicle);
    }
}
