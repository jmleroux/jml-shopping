<?php
namespace Jmleroux\Console\Command;

use Jmleroux\Api\UserService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserAdd extends Command
{
    protected function configure()
    {
        $this->setName('user:add')
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

        /** @var \Cilex\Provider\Console\ContainerAwareApplication $app */
        $app = $this->getApplication();

        /** @var UserService $userService */
        $userService = $app->getService('user_service');

        try {
            $userService->createUser($login, $password);
            $message = sprintf('User "%s" created with password "%s"', $login, $password);
            $app->getService('monolog')->addDebug($message);
            $output->writeln($message);
        }
        catch (UniqueConstraintViolationException $e) {
            $message = 'User already in database.';
            $app->getService('monolog')->addDebug($message);
            $output->writeln('<error>'.$message.'</error>');
        }
    }
}
