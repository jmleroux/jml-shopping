<?php

namespace spec\Jmleroux\Console\Command;

use PhpSpec\ObjectBehavior;

class ClearRuntimeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Console\Command\ClearRuntime');
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
