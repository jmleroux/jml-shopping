<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Jmleroux\JmlShopping\Api\ApiBundle\Command\UserDeleteCommand;
use PhpSpec\ObjectBehavior;

class UserDeleteCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserDeleteCommand::class);
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
