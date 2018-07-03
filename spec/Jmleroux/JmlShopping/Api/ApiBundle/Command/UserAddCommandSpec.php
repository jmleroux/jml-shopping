<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Jmleroux\JmlShopping\Api\ApiBundle\Command\UserAddCommand;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserAddCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserAddCommand::class);
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
