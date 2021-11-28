<?php

namespace App\Command;

use Exception;
use JsonException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:article-statistics',
    description: 'Вывод статистики статьи',
)]
class ArticleStatisticsCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('slug', InputArgument::REQUIRED, 'Символьный код')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'Формат вывода', 'text');
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');

        $data = [
            'slug' => $slug,
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'likes' => 999,
        ];

        if ($input->getOption('format') === 'text') {
            //$io->title($slug);
            //$io->listing($data);
            $io->table(array_keys($data), [$data]);
        } elseif ($input->getOption('format') === 'json') {
            $io->writeln(json_encode($data, JSON_THROW_ON_ERROR));
        } else {
            throw new Exception('Wrong --format option');
        }

        return Command::SUCCESS;
    }
}
