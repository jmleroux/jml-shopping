<?php
namespace Jmleroux\Console\Command;

use Jmleroux\Api\UserService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Knp\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserAdd extends Command
{
    protected function configure()
    {
        $this->setName("user:add")
            ->setDescription("A test command!")
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

        $app = $this->getSilexApplication();

        /** @var UserService $userService */
        $userService = $app['user_service'];

        try {
            $userService->createUser($login, $password);
            $message = sprintf('User "%s" created with password "%s"', $login, $password);
            $app['monolog']->addDebug('Testing the Monolog logging.');
            $output->writeln($message);
        }
        catch (UniqueConstraintViolationException $e) {
            $message = 'User already in database.';
            $app['monolog']->addDebug($message);
            $output->writeln('<error>'.$message.'</error>');
        }
    }
}
