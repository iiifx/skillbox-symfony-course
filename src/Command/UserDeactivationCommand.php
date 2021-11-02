<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:user:deactivate',
    description: 'Активация-деактивация пользователя',
)]
class UserDeactivationCommand extends Command
{
    protected UserRepository $userRepository;
    protected EntityManagerInterface $entityManager;

    public function __construct(
        string $name = null,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($name);

        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'User ID')
            ->addOption('reverse', null, InputOption::VALUE_REQUIRED, 'Reverse deactivation', false);
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userId = $input->getArgument('id');

        if (!$user = $this->userRepository->find($userId)) {
            throw new Exception(sprintf('User #%d not found', $userId));
        }

        $io = new SymfonyStyle($input, $output);

        if (!$input->getOption('reverse')) {
            if (!$user->isActive()) {
                $io->text(sprintf('The user #%d is already deactivated', $userId));
            } else {
                $user->setIsActive(false);
                $io->text(sprintf('User #%d deactivated successfully', $userId));
            }
        } else {
            if ($user->isActive()) {
                $io->text(sprintf('User #%d is already activated', $userId));
            } else {
                $user->setIsActive(true);
                $io->text(sprintf('User #%d activated successfully', $userId));
            }
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
