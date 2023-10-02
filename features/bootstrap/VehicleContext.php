<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;

class VehicleContext implements Context
{
    private \Fulll\Domain\Entity\Fleet $myFleet;
    private \Fulll\Domain\Entity\Vehicle $vehicle;
    private ?string $vehicleAlreadyRegisteredMessage = null;
    private \Fulll\Domain\Entity\Fleet $fleetOfAnotherUser;
    private \Fulll\Domain\ValueObject\Location $location;
    private ?string $vehicleAlreadyParkedAtThisLocationMessage = null;

    private readonly \Fulll\Domain\Repository\FleetRepositoryInterface $fleetRepository;
    private readonly \Fulll\Domain\Repository\VehicleRepositoryInterface $vehicleRepository;

    public function __construct()
    {
        $entityManager = new Fulll\Infra\Doctrine\ORM\EntityManager();

        $this->fleetRepository   = new Fulll\Infra\Repository\FleetRepository($entityManager);
        $this->vehicleRepository = new Fulll\Infra\Repository\VehicleRepository($entityManager);
    }

    /**
     * @Given my fleet
     */
    public function myFleet(): void
    {
        $this->myFleet = new Fulll\Domain\Entity\Fleet(
            id: Ramsey\Uuid\Uuid::uuid4()->toString(),
            userId: '3b2d6935-4603-4bd3-ae75-231e3344aa63'
        );

        $this->fleetRepository->save($this->myFleet);
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle(): void
    {
        $this->vehicle = new Fulll\Domain\Entity\Vehicle(
            id: '40741981-2048-4184-92a9-2f9ca51517f9',
            plateNumber: 'WW-132-PK'
        );
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $command = new Fulll\App\Command\RegisterVehicle(
            $this->myFleet->id,
            $this->vehicle->plateNumber
        );

        $handler = new Fulll\App\Command\RegisterVehicleHandler($this->fleetRepository);

        $handler->handle($command);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        $fleet   = $this->fleetRepository->getById($this->myFleet->id);
        $vehicle = $this->vehicleRepository->findOneByFleetIdAndPlateNumber(
            $fleet->id,
            $this->vehicle->plateNumber,
        );

        if (!$fleet->vehicles->contains($vehicle)) {
            throw new RuntimeException();
        }
    }

    /**
     * @Given /^I have registered this vehicle into my fleet$/
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $this->vehicle->plateNumber = 'WW-456-PY';

        $command = new Fulll\App\Command\RegisterVehicle(
            $this->myFleet->id,
            $this->vehicle->plateNumber
        );

        $handler = new Fulll\App\Command\RegisterVehicleHandler($this->fleetRepository);

        $handler->handle($command);
    }

    /**
     * @When /^I try to register this vehicle into my fleet$/
     */
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        try {
            $command = new Fulll\App\Command\RegisterVehicle(
                $this->myFleet->id,
                $this->vehicle->plateNumber
            );

            $handler = new Fulll\App\Command\RegisterVehicleHandler($this->fleetRepository);

            $handler->handle($command);
        } catch (Fulll\Domain\Exception\VehicleAlreadyRegisteredException $e) {
            $this->vehicleAlreadyRegisteredMessage = $e->getMessage();
        }
    }

    /**
     * @Then /^I should be informed this vehicle has already been registered into my fleet$/
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet(): void
    {
        if (null === $this->vehicleAlreadyRegisteredMessage) {
            throw new RuntimeException();
        }

        echo $this->vehicleAlreadyRegisteredMessage;
    }

    /**
     * @Given /^the fleet of another user$/
     */
    public function theFleetOfAnotherUser(): void
    {
        $this->fleetOfAnotherUser = new Fulll\Domain\Entity\Fleet(
            id: Ramsey\Uuid\Uuid::uuid4()->toString(),
            userId: '7b49ebb9-3e3c-4509-a402-e2e2aa3f6067'
        );

        $this->fleetRepository->save($this->fleetOfAnotherUser);
    }

    /**
     * @Given /^this vehicle has been registered into the other user's fleet$/
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUserSFleet(): void
    {
        $command = new Fulll\App\Command\RegisterVehicle(
            $this->fleetOfAnotherUser->id,
            $this->vehicle->plateNumber
        );

        $handler = new Fulll\App\Command\RegisterVehicleHandler($this->fleetRepository);

        $handler->handle($command);
    }

    /**
     * @Given /^a location$/
     */
    public function aLocation(): void
    {
        $this->location = new Fulll\Domain\ValueObject\Location(63.07061, -153.76104);
    }

    /**
     * @When /^I park my vehicle at this location$/
     */
    public function iParkMyVehicleAtThisLocation(): void
    {
        if (null === $this->location->latitude || null === $this->location->longitude) {
            throw new RuntimeException('Latitude and longitude need to be defined.');
        }

        $command = new Fulll\App\Command\ParkVehicle(
            $this->myFleet->id,
            $this->vehicle->plateNumber,
            $this->location->latitude,
            $this->location->longitude,
        );

        $handler = new Fulll\App\Command\ParkVehicleHandler($this->vehicleRepository);

        $handler->handle($command);

        // assign location to the vehicle for test purpose (avoid calling database)
        $this->vehicle->location = $this->location;
    }

    /**
     * @Then /^the known location of my vehicle should verify this location$/
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        if (null !== $this->vehicle->location && !$this->vehicle->location->sameAs($this->location)) {
            throw new RuntimeException();
        }
    }

    /**
     * @Given /^my vehicle has been parked into this location$/
     */
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        if (null === $this->location->latitude || null === $this->location->longitude) {
            throw new RuntimeException('Latitude and longitude need to be defined.');
        }

        $command = new Fulll\App\Command\ParkVehicle(
            $this->myFleet->id,
            $this->vehicle->plateNumber,
            $this->location->latitude,
            $this->location->longitude,
        );

        $handler = new Fulll\App\Command\ParkVehicleHandler($this->vehicleRepository);

        $handler->handle($command);
    }

    /**
     * @When /^I try to park my vehicle at this location$/
     */
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        try {
            if (null === $this->location->latitude || null === $this->location->longitude) {
                throw new RuntimeException('Latitude and longitude need to be defined.');
            }

            $command = new Fulll\App\Command\ParkVehicle(
                $this->myFleet->id,
                $this->vehicle->plateNumber,
                $this->location->latitude,
                $this->location->longitude,
            );

            $handler = new Fulll\App\Command\ParkVehicleHandler($this->vehicleRepository);

            $handler->handle($command);
        } catch (Exception $e) {
            $this->vehicleAlreadyParkedAtThisLocationMessage = $e->getMessage();
        }
    }

    /**
     * @Then /^I should be informed that my vehicle is already parked at this location$/
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        if (null === $this->vehicleAlreadyParkedAtThisLocationMessage) {
            throw new RuntimeException();
        }

        echo $this->vehicleAlreadyParkedAtThisLocationMessage;
    }
}
