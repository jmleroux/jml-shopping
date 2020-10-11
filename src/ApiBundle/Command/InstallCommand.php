<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    /** @var Connection */
    private $connection;
    /** @var ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container, Connection $connection)
    {
        parent::__construct();
        $this->container = $container;
        $this->connection = $connection;
    }

    protected function configure()
    {
        $this->setName('jmlshopping:install')
            ->setDescription('Install application');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->connection->executeStatement("PRAGMA foreign_keys = ON;");
        $this->connection->beginTransaction();
        $this->createSchema($output);
        $this->loadFixtures($output);
        $this->connection->commit();
    }

    private function createSchema(OutputInterface $output): void
    {
        $file = $this->container->getParameter('kernel.root_dir') . '/config/sql/schema.sql';
        $sql = file_get_contents($file);
        $this->executeFixtures($output, $sql);
    }

    private function loadFixtures(OutputInterface $output): void
    {
        $file = $this->container->getParameter('kernel.root_dir') . '/config/sql/fixtures-fr.sql';
        $sql = file_get_contents($file);
        $this->executeFixtures($output, $sql);
    }

    private function executeFixtures(OutputInterface $output, string $sql): void
    {
        $output->writeln(sprintf('Execute command <info>"%s"</info>', $sql));
        $this->connection->executeQuery($sql);
    }
}
