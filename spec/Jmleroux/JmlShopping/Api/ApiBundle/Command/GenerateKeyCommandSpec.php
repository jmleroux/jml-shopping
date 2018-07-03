<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Jmleroux\JmlShopping\Api\ApiBundle\Command\GenerateKeyCommand;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateKeyCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GenerateKeyCommand::class);
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }

    function it_can_run(InputInterface $input, OutputInterface $output)
    {
        $this->run($input, $output)->shouldReturn(0);
    }
}
