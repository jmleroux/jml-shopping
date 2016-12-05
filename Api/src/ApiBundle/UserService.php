<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle;

use Doctrine\DBAL\Connection;

class UserService
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @var string encryption key should be 16, 24 or 32 characters long form 128, 192, 256 bit encryption
     */
    protected $encryptionKey;

    public function __construct(Connection $db, $encryptionKey)
    {
        $this->db = $db;
        $this->encryptionKey = $encryptionKey;
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
