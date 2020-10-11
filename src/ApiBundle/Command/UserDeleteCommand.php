<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Doctrine\DBAL\DBALException;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserDeleteCommand extends Command
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

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

        try {
            $this->userRepository->deleteUser($login);
            $message = sprintf('User "%s" deleted', $login);
            $output->writeln($message);
        } catch (DBALException $e) {
            $message = 'User not found in database.';
            $output->writeln('<error>' . $message . '</error>');
        }
    }
}
