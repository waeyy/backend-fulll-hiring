<?php

declare(strict_types=1);

namespace Fulll\Infra\Symfony\Command;

use Fulll\App\Command\ParkVehicle;
use Fulll\App\Command\ParkVehicleHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'fleet:vehicle:localize')]
class LocalizeVehicleCommand extends Command
{
    public function __construct(
        private readonly ParkVehicleHandler $parkVehicleHandler,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet Id');
        $this->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Plate number of the vehicle');
        $this->addArgument('lat', InputArgument::REQUIRED, 'Location latitude');
        $this->addArgument('lng', InputArgument::REQUIRED, 'Location longitude');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fleetId            = $input->getArgument('fleetId');
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');
        $lat                = $input->getArgument('lat');
        $lng                = $input->getArgument('lng');

        /** @phpstan-ignore-next-line */
        $command = new ParkVehicle($fleetId, $vehiclePlateNumber, $lat, $lng);

        $this->parkVehicleHandler->handle($command);

        /** @phpstan-ignore-next-line */
        $message = sprintf('Vehicle %s successfully parked at [%.2f;%.2f].', $vehiclePlateNumber, $lat, $lng);

        $output->writeln($message);

        return Command::SUCCESS;
    }
}
