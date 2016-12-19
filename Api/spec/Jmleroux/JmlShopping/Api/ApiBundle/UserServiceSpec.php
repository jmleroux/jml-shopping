<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\UserService;
use PhpSpec\ObjectBehavior;

class UserServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserService::class);
    }
    function let(Connection $db)
    {
        $this->beConstructedWith($db, 'foobar');
    }
}
