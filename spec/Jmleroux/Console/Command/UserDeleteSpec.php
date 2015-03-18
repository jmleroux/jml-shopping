<?php

namespace spec\Jmleroux\Console\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserDeleteSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Console\Command\UserDelete');
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
