<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Security;

use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    /** @var Security */
    private $security;
    /** @var string */
    private $googleClientId;
    /** @var string */
    private $googleSecret;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Security $security,
        LoggerInterface $logger,
        string $googleClientId,
        string $googleSecret
    ) {
        $this->security = $security;
        $this->googleClientId = $googleClientId;
        $this->googleSecret = $googleSecret;
        $this->logger = $logger;
    }

    public function getCredentials(Request $request)
    {
        $token = $request->headers->get('X-AUTH-TOKEN');

        $this->logger->notice(sprintf('Auth token: %s', $token));

        return [
            'token' => $token,
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $provider = new Google([
            'clientId' => $this->googleClientId,
            'clientSecret' => $this->googleSecret,
            'redirectUri' => 'https://example.com/callback-url',
        ]);

        $token = $credentials['token'];

        if (!$token) {
            throw new AuthenticationException('No token found.');
        }

        try {
            $googleUser = $provider->getResourceOwner(new AccessToken(['access_token' => $token]))->toArray();
        } catch (\Exception $e) {
            throw new AuthenticationException('Bad access token.');
        }

        if (!isset($googleUser['email'])) {
            throw new AuthenticationException('Bad access token.');
        }

        return $userProvider->loadUserByUsername($googleUser['email']);
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
        if ($this->security->getUser()) {
            return false;
        }

        return true;
    }
}
