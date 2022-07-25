<?php

namespace App\Command;

use App\Tasks\Task3\ParcelPriceCalculationFactory;
use App\Tasks\Task3\PostalParcel;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Task3Command extends Command
{
    protected ParcelPriceCalculationFactory $factory;
    protected static $defaultName = 'app:task3';
    protected static $defaultDescription = 'Add a short description for your command';

    public function __construct(ParcelPriceCalculationFactory $factory) {
        $this->factory = $factory;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('weight', InputArgument::OPTIONAL, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $weight = (int) $input->getArgument('weight');

        if ($weight <= 0) {
            throw new InvalidArgumentException("weight is not correct");
        }

        $prices = $this->factory->getAllPrices(new PostalParcel($weight));
        print($this->factory->decorateAnswer($prices));

        return Command::SUCCESS;
    }
}
