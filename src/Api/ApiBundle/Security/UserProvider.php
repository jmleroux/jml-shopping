<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /** @var Connection */
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function loadUserByUsername($token)
    {
        $qb = $this->db->createQueryBuilder();

        $qb->select('login')
            ->from('users', 'u')
            ->where('password = :password')
            ->setParameter('password', $token);

        $result = $qb->execute();
        $row = $result->fetch(\PDO::FETCH_ASSOC);

        $user = null;
        if ($row) {
            $user = new User();
            $user->eraseCredentials();
        }

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
