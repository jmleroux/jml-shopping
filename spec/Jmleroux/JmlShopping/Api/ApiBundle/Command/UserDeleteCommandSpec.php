<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Command;

use Jmleroux\JmlShopping\Api\ApiBundle\Command\UserDeleteCommand;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Command\Command;

class UserDeleteCommandSpec extends ObjectBehavior
{
    function let(UserRepository $userRepository)
    {
        $this->beConstructedWith($userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserDeleteCommand::class);
        $this->shouldHaveType(Command::class);
    }
}
