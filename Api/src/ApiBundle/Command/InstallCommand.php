<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('jmlshopping:install')
            ->setDescription('Install application');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dbPath = $this->getContainer()->getParameter('db_path');
        $fixtures = $this->getContainer()->getParameter('kernel.root_dir') . '/app/Resources/setup-db.sql';
        $cmd = sprintf("sqlite3 %s < %s", $dbPath, $fixtures);
        $output->writeln(sprintf('Execute command <info>"%s"</info>', $cmd));
        exec($cmd);
    }
}
