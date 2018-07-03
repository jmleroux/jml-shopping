<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    public function getCredentials(Request $request)
    {
        $token = $request->headers->get('X-AUTH-TOKEN');

        return [
            'token' => $token,
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $credentials['token'];

        if (!$token) {
            throw new AuthenticationException('No token found.');
        }

        return $userProvider->loadUserByUsername($token);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, 403);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'message' => 'Authentication Required',
        ];

        return new JsonResponse($data, 401);
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function supports(Request $request): bool
    {
        return $request->headers->has('X-AUTH-TOKEN');
    }
}
