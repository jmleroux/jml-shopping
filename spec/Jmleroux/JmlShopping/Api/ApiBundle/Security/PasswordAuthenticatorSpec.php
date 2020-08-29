<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use Jmleroux\JmlShopping\Api\ApiBundle\Security\PasswordEncoder;
use Jmleroux\JmlShopping\Api\ApiBundle\Security\TokenEncoder;
use Jmleroux\JmlShopping\Api\ApiBundle\Security\PasswordAuthenticator;
use PhpSpec\ObjectBehavior;

class PasswordAuthenticatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PasswordAuthenticator::class);
    }

    function let(UserRepository $userRepository, PasswordEncoder $passwordEncoder, TokenEncoder $tokenEncoder)
    {
        $this->beConstructedWith($userRepository, $passwordEncoder, $tokenEncoder, 'foobar');
    }
}
