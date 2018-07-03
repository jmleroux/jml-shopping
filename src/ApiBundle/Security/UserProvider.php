<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\User;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /** @var Connection */
    private $db;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(Connection $db, UserRepository $userRepository)
    {
        $this->db = $db;
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername($token)
    {
        if (!$this->userRepository->tokenIsValid($token)) {
            return null;
        }

        list($username, $base64Token) = explode('-+-', $token);

        $user = $this->userRepository->findByUsername($username);

        if (null === $user) {
            return null;
        }

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
