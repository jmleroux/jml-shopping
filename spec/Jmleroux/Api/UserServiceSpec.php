<?php

namespace spec\Jmleroux\Api;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Silex\Application;

class UserServiceSpec extends ObjectBehavior
{
    function let(Application $application)
    {
        $this->beConstructedWith($application);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Api\UserService');
    }
}
