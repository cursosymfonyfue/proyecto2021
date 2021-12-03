<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddRoleToUser extends Command
{
    protected static $defaultName = 'app:user:add-role';

    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserRepository  $userRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import posts from reddit');
        $this->addArgument('email', InputArgument::REQUIRED, 'The email of the user.');
        $this->addArgument('role', InputArgument::REQUIRED, 'The role of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userRepository->findOneBy(['email' => $input->getArgument('email')]);

        if ($user) {
            $user->addRole($input->getArgument('role'));

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return Command::SUCCESS;
    }
}
