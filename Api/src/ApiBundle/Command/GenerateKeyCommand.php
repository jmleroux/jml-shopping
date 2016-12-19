<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Defuse\Crypto\Key;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateKeyCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('jmlshopping:key:generate')
            ->setDescription('Generate application secret key');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $key = Key::createNewRandomKey();
        $asciiKey = $key->saveToAsciiSafeString();
        $output->writeln(sprintf('Secret key = <info>"%s"</info>', $asciiKey));
    }
}
