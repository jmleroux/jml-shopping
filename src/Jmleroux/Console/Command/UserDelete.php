<?php
namespace Jmleroux\Console\Command;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Jmleroux\Core\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserDelete extends Command
{
    protected function configure()
    {
        $this->setName('user:del')
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

        /** @var \Cilex\Provider\Console\ContainerAwareApplication $app */
        $app = $this->getApplication();

        /** @var UserService $userService */
        $userService = $app->getService('user_service');

        try {
            $userService->deleteUser($login);
            $message = sprintf('User "%s" deleted', $login);
            $app->getService('monolog')->addDebug($message);
            $output->writeln($message);
        }
        catch (UniqueConstraintViolationException $e) {
            $message = 'User not found in database.';
            $app->getService('monolog')->addDebug($message);
            $output->writeln('<error>'.$message.'</error>');
        }
    }
}
