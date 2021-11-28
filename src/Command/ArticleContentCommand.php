<?php

namespace App\Command;

use Exception;
use SkillboxSymfony\ArticleContentProviderBundle\ArticleContentProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:article:content_provider',
    description: 'Дом.задание, консольный контроллер',
)]
class ArticleContentCommand extends Command
{
    private ArticleContentProvider $provider;

    /**
     * @required
     */
    public function setProvider(ArticleContentProvider $provider): void
    {
        $this->provider = $provider;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('paragraphs', InputArgument::REQUIRED, 'Кол-во параграфов')
            ->addArgument('word', InputArgument::OPTIONAL, 'Слово', null)
            ->addArgument('wordsCount', InputArgument::OPTIONAL, 'Кол-во слов', 0);
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $paragraphs = $input->getArgument('paragraphs');

        if ($paragraphs <= 0) {
            throw new Exception('Wrong paragraphs argument');
        }

        $content = $this->provider->get(
            $paragraphs,
            $input->getArgument('word'),
            (int)$input->getArgument('wordsCount'),
        );

        $io->writeln($content);

        return Command::SUCCESS;
    }
}
