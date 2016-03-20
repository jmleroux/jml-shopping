<?php
namespace Jmleroux\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearRuntime extends Command
{
    protected function configure()
    {
        $this->setName('runtime:clear')
            ->setDescription('Clear logs and cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Cilex\Provider\Console\ContainerAwareApplication $app */
        $app = $this->getApplication();

        $applicationLog = $app->getService('monolog.logfile');
        unlink($applicationLog);

        $cache = $app->getService('app.root') . '/var';
        exec(sprintf('rm -rf %s/*', $cache));
    }
}
