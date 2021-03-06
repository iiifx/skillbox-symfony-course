<?php

namespace App\Command;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:weekly-newsletter',
    description: 'Рассылка',
)]
class WeeklyNewsletterCommand extends Command
{
    public function __construct(
        protected UserRepository $userRepository,
        protected ArticleRepository $articleRepository,
        protected Mailer $mailer
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $articles = $this->articleRepository->findAllPublishedLastWeek();
        if (!$articles) {
            $io->warning('За последнюю неделю нет опубликованных статей');

            return Command::SUCCESS;
        }

        //$users = $this->userRepository->findAllSubscribed();
        $users = $this->userRepository->findBy(['isActive' => 1]);

        $io->progressStart(count($users));
        foreach ($users as $user) {
            $this->mailer->sendNewsletter($user, $articles);

            $io->progressAdvance();
        }
        $io->progressFinish();

        return Command::SUCCESS;
    }
}
