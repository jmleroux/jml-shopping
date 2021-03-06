<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Repository;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\User;

class UserRepository
{
    private const TABLENAME = 'users';

    /**
     * @var Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function findByUsername(string $username): ?User
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('login')
            ->from(self::TABLENAME, 'u')
            ->where('login = :username')
            ->setParameter('username', $username, \PDO::PARAM_STR);

        $stmt = $qb->execute();

        $row = $stmt->fetchAssociative();

        if (!$row) {
            return null;
        }

        return User::create($row['login']);
    }

    public function save(User $user)
    {
        $sql = 'INSERT INTO users (login) VALUES (?);';
        $values = [$user->getUsername()];
        $this->db->executeUpdate($sql, $values);
    }

    public function deleteUser($username)
    {
        $sql = 'DELETE FROM users WHERE login=?;';
        $values = [$username];
        $this->db->executeUpdate($sql, $values);
    }
}
