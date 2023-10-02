<?php

declare(strict_types=1);

namespace Fulll\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Location
{
    public function __construct(
        #[ORM\Column(type: 'float', nullable: true)]
        public ?float $latitude = null,
        #[ORM\Column(type: 'float', nullable: true)]
        public ?float $longitude = null
    ) {
    }

    public function sameAs(Location $location): bool
    {
        return $this->latitude === $location->latitude && $this->longitude === $location->longitude;
    }
}
