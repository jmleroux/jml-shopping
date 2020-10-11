<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Jmleroux\JmlShopping\Api\ApiBundle\Security\TokenAuthenticator;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class TokenAuthenticatorSpec extends ObjectBehavior
{
    function let(Security $security, Request $request, HeaderBag $headers)
    {
        $this->beConstructedWith($security, 'google_id', 'google_secret');

        $headers->get('X-AUTH-TOKEN')->willReturn('foo-token');
        $request->headers = $headers;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TokenAuthenticator::class);
    }

    function it_can_get_credentials(Request $request)
    {
        $this->getCredentials($request)->shouldReturn(['token' => 'foo-token']);
    }

    function it_must_authenticate(UserProviderInterface $userProvider, UserInterface $user)
    {
        $credentials = ['token' => 'foo-token'];
        $userProvider->loadUserByUsername('foo-token')
            ->shouldNotBeCalled();

        $this->shouldThrow(AuthenticationException::class)
            ->during('getUser', [$credentials, $userProvider]);
    }

    function it_does_not_support_remember_me()
    {
        $this->supportsRememberMe()
            ->shouldReturn(false);
    }
}
