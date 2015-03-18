<?php

namespace spec\Jmleroux\Console\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserAddSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Console\Command\UserAdd');
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
