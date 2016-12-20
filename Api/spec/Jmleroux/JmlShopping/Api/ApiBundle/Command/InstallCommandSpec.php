<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Jmleroux\JmlShopping\Api\ApiBundle\Command\InstallCommand;
use PhpSpec\ObjectBehavior;

class InstallCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InstallCommand::class);
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
