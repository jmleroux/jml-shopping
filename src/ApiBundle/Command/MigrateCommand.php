<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command
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
        $this->setName('jmlshopping:migrate')
            ->setDescription('Execute a migration')
            ->addArgument(
                'migration_filename',
                InputArgument::REQUIRED,
                'Migration file'
            );;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $migrationFilename = $input->getArgument('migration_filename');

        $this->connection->executeStatement("PRAGMA foreign_keys = ON;");
        $this->connection->beginTransaction();
        $this->playMigration($output, $migrationFilename);
        $this->connection->commit();

        return 0;
    }

    private function playMigration(OutputInterface $output, string $migrationFilename): void
    {
        $filepath = sprintf('%s/config/sql/%s.sql',
            $this->container->getParameter('kernel.root_dir'),
            $migrationFilename
        );
        if (!file_exists($filepath)) {
            throw new \InvalidArgumentException(sprintf('Migration file not found: %s', $filepath));
        }
        $sql = file_get_contents($filepath);
        $this->executeSql($output, $sql);
    }

    private function executeSql(OutputInterface $output, string $sql): void
    {
        $output->writeln(sprintf('Execute command <info>"%s"</info>', $sql));
        $this->connection->executeStatement($sql);
    }
}
