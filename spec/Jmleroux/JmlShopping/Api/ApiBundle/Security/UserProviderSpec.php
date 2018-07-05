<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\User;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use Jmleroux\JmlShopping\Api\ApiBundle\Security\TokenValidator;
use Jmleroux\JmlShopping\Api\ApiBundle\Security\UserProvider;
use Jmleroux\JmlShopping\Api\ApiBundle\UserService;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserProvider::class);
        $this->shouldImplement(UserProviderInterface::class);
    }

    function let(Connection $db, UserRepository $repository, TokenValidator $tokenValidator)
    {
        $this->beConstructedWith($db, $repository, $tokenValidator);
    }

    function it_supports_user_class()
    {
        $this->supportsClass(User::class)->shouldReturn(true);
    }
}
