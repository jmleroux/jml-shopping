<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserAddCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('jmlshopping:user:add')
            ->setDescription('Add user')
            ->addArgument(
                'login',
                InputArgument::REQUIRED,
                'User login'
            )
            ->addArgument(
                'password',
                InputArgument::REQUIRED,
                'User password'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $login = $input->getArgument('login');
        $password = $input->getArgument('password');

        $userService = $this->getContainer()->get('jmlshopping.user');

        try {
            $userService->createUser($login, $password);
            $message = sprintf('User "%s" created with password "%s"', $login, $password);
            $output->writeln($message);
        }
        catch (DBALException $e) {
            $message = 'User already in database.';
            $output->writeln('<error>'.$message.'</error>');
        }
    }
}
