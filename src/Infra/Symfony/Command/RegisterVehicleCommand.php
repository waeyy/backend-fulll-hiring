<?php

declare(strict_types=1);

namespace Fulll\Infra\Symfony\Command;

use Fulll\App\Command\RegisterVehicle;
use Fulll\App\Command\RegisterVehicleHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'fleet:vehicle:register')]
class RegisterVehicleCommand extends Command
{
    public function __construct(
        private readonly RegisterVehicleHandler $registerVehicleHandler,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet Id');
        $this->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Plate number of the vehicle');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fleetId            = $input->getArgument('fleetId');
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');

        /** @phpstan-ignore-next-line */
        $command = new RegisterVehicle($fleetId, $vehiclePlateNumber);

        $this->registerVehicleHandler->handle($command);

        /* @phpstan-ignore-next-line */
        $output->writeln(sprintf('Vehicle %s registered.', $vehiclePlateNumber));

        return Command::SUCCESS;
    }
}
