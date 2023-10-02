<?php

declare(strict_types=1);

namespace Fulll\Infra\Symfony\Command;

use Fulll\App\Command\CreateFleet;
use Fulll\App\Command\CreateFleetHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'fleet:create')]
class CreateFleetCommand extends Command
{
    public function __construct(
        private readonly CreateFleetHandler $createFleetHandler,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('userId', InputArgument::REQUIRED, 'User Id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userId = $input->getArgument('userId');

        /** @phpstan-ignore-next-line */
        $command = new CreateFleet($userId);

        $fleetId = $this->createFleetHandler->handle($command);

        $output->writeln($fleetId);

        return Command::SUCCESS;
    }
}
