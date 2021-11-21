<?php

namespace App\Command;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

#[AsCommand(
    name: 'app:admin-statistic-report',
    description: 'Отчет администратору',
)]
class AdminStatisticReportCommand extends Command
{
    public function __construct(
        protected UserRepository $userRepository,
        protected ArticleRepository $articleRepository,
        protected MailerInterface $mailer
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email получателя')
            ->addOption('dateFrom', 'f', InputArgument::OPTIONAL, 'Дата начала периода', '-1 week')
            ->addOption('dateTo', 't', InputArgument::OPTIONAL, 'Дата окончания периода', 'now');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $toEmail = $input->getArgument('email');

        try {
            $dateFrom = new DateTimeImmutable($input->getOption('dateFrom'));
            $dateTo = new DateTimeImmutable($input->getOption('dateTo'));
        } catch (Exception $e) {
            $io->warning($e->getMessage());

            return Command::FAILURE;
        }

        if (!$tempFile = tempnam(sys_get_temp_dir(), 'report')) {
            $io->warning('Не удалось создать временный файл');

            return Command::FAILURE;
        }
        if (!$resource = fopen($tempFile, 'rb+')) {
            return Command::FAILURE;
        }

        fputcsv($resource, [
            'Период',
            'Всего пользователей',
            'Статей создано за период',
            'Статей опубликовано за период'
        ]);
        fputcsv($resource, [
            sprintf('%s - %s', $dateFrom->format('d.m.Y'), $dateTo->format('d.m.Y')),
            $this->userRepository->count([]),
            $this->articleRepository->countCreated($dateFrom, $dateTo),
            $this->articleRepository->countPublished($dateFrom, $dateTo),
        ]);

        $email = (new TemplatedEmail())
            ->from(new Address('noreply@symfony.skillbox', 'Project'))
            ->to($toEmail)
            ->subject('Отчет администратору')
            ->text('Отчет прикреплен к письму')
            ->attach($resource, 'report.csv');

        $this->mailer->send($email);

        $io->writeln('Отчет отправлен: ' . $toEmail);

        return Command::SUCCESS;
    }
}
