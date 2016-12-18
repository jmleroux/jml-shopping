<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\User;
use Jmleroux\JmlShopping\Api\ApiBundle\UserService;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /** @var Connection */
    private $db;

    /** @var UserService */
    private $userService;

    public function __construct(Connection $db, UserService $userService)
    {
        $this->db = $db;
        $this->userService = $userService;
    }

    public function loadUserByUsername($token)
    {
        if (!$this->userService->tokenIsValid($token)) {
            return null;
        }

        list($username, $base64Token) = explode('-+-', $token);

        $row = $this->userService->loadUserByUsername($username);

        if (!$row) {
            return null;
        }

        $user = new User();
        $user->eraseCredentials();

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
