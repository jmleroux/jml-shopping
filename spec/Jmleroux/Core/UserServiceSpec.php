<?php

namespace spec\Jmleroux\Core;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserServiceSpec extends ObjectBehavior
{
    function let(Connection $db)
    {
        $this->beConstructedWith($db, 'foobar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Core\UserService');
    }
}
