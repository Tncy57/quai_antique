<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:user:grant-admin-role',
    description: 'This command changes the role of the user',
)]
class GrantAdminRoleCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }  

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
      $io = new SymfonyStyle($input, $output);
      $userId = $input->getArgument('arg1');
  
      if ($userId) {
          $userRepository = $this->entityManager->getRepository(User::class);
          $user = $userRepository->find($userId);
  
          if ($user) {
              $user->setRoles(['ROLE_ADMIN']);
              $this->entityManager->flush();
  
              $io->success(sprintf('User with ID %d has been granted the admin role.', $user->getId()));
              return Command::SUCCESS;
          } else {
              $io->error('User not found.');
              return Command::FAILURE;
          }
      } else {
          $io->error('User ID argument is missing.');
          return Command::FAILURE;
      }
    }
}

