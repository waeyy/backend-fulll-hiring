<?php

declare(strict_types=1);

namespace Fulll\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fulll\Domain\Exception\VehicleAlreadyParkedAtThisLocationException;
use Fulll\Domain\ValueObject\Location;

#[ORM\Entity]
class Vehicle
{
    #[ORM\ManyToOne(targetEntity: Fleet::class, inversedBy: 'vehicles')]
    #[ORM\JoinColumn(nullable: false)]
    public Fleet $fleet;

    #[ORM\Embedded(class: Location::class)]
    public ?Location $location = null;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string', length: 36)]
        public string $id,
        #[ORM\Column(type: 'string', length: 9)]
        public string $plateNumber,
    ) {
    }

    public function park(Location $location): void
    {
        if (null !== $this->location && $this->location->sameAs($location)) {
            throw new VehicleAlreadyParkedAtThisLocationException();
        }

        $this->location = $location;
    }
}
