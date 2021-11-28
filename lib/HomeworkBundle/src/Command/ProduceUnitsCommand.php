<?php

declare(strict_types=1);

namespace SymfonySkillbox\HomeworkBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use SymfonySkillbox\HomeworkBundle\Unit;
use SymfonySkillbox\HomeworkBundle\UnitFactory;

class ProduceUnitsCommand extends Command
{
    public function __construct(
        protected UnitFactory $unitFactory
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('symfony-skillbox-homework:produce-units')
            ->setDescription('Produce units')
            ->addArgument('resources', InputArgument::REQUIRED, 'Resources');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $resources = (int)$input->getArgument('resources');

        $units = $this->unitFactory->produceUnits($resources);
        $unitsCost = 0;
        array_walk($units, static function (Unit $u) use (&$unitsCost): void {
            $unitsCost += $u->getCost();
        });

        //  На 593 было куплено 5 юнитов
        //  ------------ ------ ------ ----------
        //  Имя          Цена   Сила   Здоровье
        //  ------------ ------ ------ ----------
        //  Лучник       150    6      50
        //  Лучник       150    6      50
        //  Лучник       150    6      50
        //  Солдат       100    5      100
        //  Крестьянин   33     1      1
        //  ------------ ------ ------ ----------
        //
        //  Осталось ресурсов: 10

        $io->text(sprintf('На %d было куплено %d юнитов', $resources, count($units)));
        $io->table(
            ['Имя', 'Цена', 'Сила', 'Здоровье'],
            array_map(static fn(Unit $u) => [$u->getName(), $u->getCost(), $u->getStrength(), $u->getHealth()], $units)
        );
        $io->text(sprintf('Осталось ресурсов: %d', $resources - $unitsCost));
        $io->newLine();

        return Command::SUCCESS;
    }
}
