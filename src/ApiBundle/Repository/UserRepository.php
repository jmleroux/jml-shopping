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
        $qb->select('uid, login, password')
            ->from(self::TABLENAME, 'u')
            ->where('login = ?')
            ->values([$username]);

        $stmt = $qb->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return User::create($row['id'], $row['name'], $row['password']);
    }

    public function createUser($login, $clearPassword)
    {
        $encryptedPassword = password_hash($clearPassword, PASSWORD_BCRYPT);
        $sql = 'INSERT INTO users (login, password) VALUES (?, ?);';
        $values = [$login, $encryptedPassword];
        $this->db->executeUpdate($sql, $values);
    }

    public function deleteUser($login)
    {
        $sql = 'DELETE FROM users WHERE login=?;';
        $values = [$login];
        $this->db->executeUpdate($sql, $values);
    }
}
