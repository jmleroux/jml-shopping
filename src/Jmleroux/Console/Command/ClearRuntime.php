<?php
namespace Jmleroux\Console\Command;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearRuntime extends Command
{
    protected function configure()
    {
        $this->setName("runtime:clear")
            ->setDescription("Clear logs and cache");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $applicationLog = $app['monolog.logfile'];
        file_put_contents($applicationLog, '');

        $cache = $app['app.root'] . '/cache';
        exec(sprintf('rm -rf %s/*', $cache));
    }
}
