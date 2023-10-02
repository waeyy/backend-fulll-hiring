<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Repository\FleetRepositoryInterface;
use Ramsey\Uuid\Uuid;

class CreateFleetHandler
{
    public function __construct(private readonly FleetRepositoryInterface $fleetRepository)
    {
    }

    public function handle(CreateFleet $command): string
    {
        $fleet = new Fleet(Uuid::uuid4()->toString(), $command->userId);

        $this->fleetRepository->save($fleet);

        return $fleet->id;
    }
}
