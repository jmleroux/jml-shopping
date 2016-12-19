<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserDeleteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('jmlshopping:user:del')
            ->setDescription('Delete user')
            ->addArgument(
                'login',
                InputArgument::REQUIRED,
                'User login'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $login = $input->getArgument('login');

        $userService = $this->getContainer()->get('jmlshopping.user');

        try {
            $userService->deleteUser($login);
            $message = sprintf('User "%s" deleted', $login);
            $output->writeln($message);
        }
        catch (DBALException $e) {
            $message = 'User not found in database.';
            $output->writeln('<error>'.$message.'</error>');
        }
    }
}
