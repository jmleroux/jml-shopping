<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle;

use Crypto;
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

    protected $tokenLifetime = 3600;

    public function __construct(Connection $db, $encryptionKey)
    {
        $this->db = $db;
        $this->encryptionKey = $encryptionKey;
    }

    /**
     * @param $username
     * @param $password
     *
     * @return array
     */
    public function authenticate($username, $password)
    {
        $sql = 'SELECT login, password
        FROM users u
        WHERE u.login = ?';

        $values = [$username];
        $row = $this->db->fetchAssoc($sql, $values);

        $authenticationResult = [
            'username' => $username,
            'token' => '',
        ];
        if (!empty($row)) {
            $verified = password_verify($password, $row['password']);
            if ($verified) {
                $authenticationResult['token'] = $this->encryptToken($username);
            }
        }

        return $authenticationResult;
    }

    /**
     * @param string $username
     *
     * @return array
     */
    public function loadUserByUsername($username)
    {
        $sql = 'SELECT login, password
        FROM users u
        WHERE u.login = ?';

        $values = [$username];
        $row = $this->db->fetchAssoc($sql, $values);

        if (empty($row)) {
            return null;
        }

        return $row;
    }

    private function encryptToken($username)
    {
        $token = Crypto::Encrypt($username . '-+-' . time(), $this->encryptionKey);

        return $username . '-+-' . base64_encode($token);
    }

    public function decryptToken($token)
    {
        $decrypted = Crypto::Decrypt($token, $this->encryptionKey);
        if ($decrypted) {
            list($userToken, $time) = explode('-+-', $decrypted);
        }

        return $decrypted;
    }

    public function tokenIsValid($payload)
    {
        list($username, $base64Token) = explode('-+-', $payload);
        $token = base64_decode($base64Token);
        $decrypted = Crypto::Decrypt($token, $this->encryptionKey);
        if ($decrypted) {
            list($secretUsername, $time) = explode('-+-', $decrypted);
            if ($secretUsername != $username) {
                return false;
            }
            if (time() - (int)$time > $this->tokenLifetime) {
                return false;
            }

            return true;
        }

        return false;
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
