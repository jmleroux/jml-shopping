<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle;

use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use Jmleroux\JmlShopping\Api\ApiBundle\Security\PasswordEncoder;
use Jmleroux\JmlShopping\Api\ApiBundle\UserService;
use PhpSpec\ObjectBehavior;

class UserServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserService::class);
    }

    function let(UserRepository $userRepository, PasswordEncoder $passwordEncoder)
    {
        $this->beConstructedWith($userRepository, $passwordEncoder, 'foobar');
    }
}
