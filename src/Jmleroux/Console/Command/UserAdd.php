<?php
namespace Jmleroux\ConsoleCommand;

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

        /** @var UserService $userService */
        $userService = $this->getSilexApplication()['user_service'];

        try {
            $userService->createUser($login, $password);
            $output->writeln(sprintf('User "%s" created with password "%s"', $login, $password));
        }
        catch (UniqueConstraintViolationException $e) {
            $output->writeln('User already in database.');
        }
    }
}
