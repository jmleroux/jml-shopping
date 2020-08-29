<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Jmleroux\JmlShopping\Api\ApiBundle\Security\TokenAuthenticator;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class TokenAuthenticatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TokenAuthenticator::class);
    }

    function let(Request $request, HeaderBag $headers)
    {
        $headers->get('X-AUTH-TOKEN')->willReturn('foo-token');
        $request->headers = $headers;
    }

    function it_can_get_credentials(Request $request)
    {
        $this->getCredentials($request)->shouldReturn(['token' => 'foo-token']);
    }

    function it_can_get_user(UserProviderInterface $userProvider, UserInterface $user)
    {
        $credentials = ['token' => 'foo-token'];
        $userProvider->loadUserByUsername('foo-token')
            ->willReturn($user);
        $this->getUser($credentials, $userProvider)
            ->shouldReturn($user);
    }

    function it_does_not_support_remember_me()
    {
        $this->supportsRememberMe()
            ->shouldReturn(false);
    }
}
