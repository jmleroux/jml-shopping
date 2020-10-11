<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Doctrine\DBAL\DBALException;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\User;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserAddCommand extends Command
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('jmlshopping:user:add')
            ->setDescription('Add user')
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
            $user = User::create($login);
            $this->userRepository->save($user);
            $message = sprintf('User "%s" created', $login);
            $output->writeln($message);
        } catch (DBALException $e) {
            $message = 'User already in database.';
            $output->writeln('<error>' . $message . '</error>');
            $output->writeln($e->getMessage());
        }
    }
}
