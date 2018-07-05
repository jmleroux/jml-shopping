<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\User;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\User\UserInterface;

class UserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('create', ['admin', 'pwd']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
        $this->shouldImplement(UserInterface::class);
    }

    function it_can_get_username()
    {
        $this->getUsername()->shouldReturn('admin');
    }

    function it_can_get_password()
    {
        $this->getPassword()->shouldReturn('pwd');
    }

    function it_can_erase_credentials()
    {
        $this->eraseCredentials();
        $this->getPassword()->shouldReturn('');
    }

    function it_can_get_roles()
    {
        $this->getRoles()->shouldReturn(['ROLE_USER']);
    }

    function it_does_not_use_salt()
    {
        $this->getSalt()->shouldReturn(null);
    }
}
