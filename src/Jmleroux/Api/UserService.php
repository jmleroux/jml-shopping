<?php

namespace Jmleroux\Api;

use Doctrine\DBAL\Connection;
use Keboola\Encryption\AesEncryptor;
use Silex;

class UserService
{
    /**
     * @var \Silex\Application
     */
    protected $app;

    /**
     * @var string encryption key should be 16, 24 or 32 characters long form 128, 192, 256 bit encryption
     */
    protected $encryptionKey;

    protected $tokenLifetime = 3600;

    public function __construct(Silex\Application $app)
    {
        $this->app           = $app;
        $this->encryptionKey = $app['seed'];
    }

    public function authenticate($username, $password)
    {
        $sql = 'SELECT login, password
        FROM users u
        WHERE u.login = ?';

        $values = [$username];
        $row    = $this->getDb()->fetchAssoc($sql, $values);

        $authenticationResult = [
            'username' => $username,
            'token'    => '',
        ];
        if (!empty($row)) {
            $verified = password_verify($password, $row['password']);
            if ($verified) {
                $authenticationResult['token'] = $this->encryptToken($username);
            }
        }

        return $authenticationResult;
    }

    private function encryptToken($username)
    {
        $encryptor = $this->getEncryptor();
        $token     = $encryptor->encrypt($username . '-+-' . time());

        return $username . '-+-' . base64_encode($token);
    }

    public function tokenIsValid($payload)
    {
        list($username, $base64Token) = explode('-+-', $payload);
        $token     = base64_decode($base64Token);
        $encryptor = $this->getEncryptor();
        $decrypted = $encryptor->decrypt($token);
        if ($decrypted) {
            list($tokenUsername, $time) = explode('-+-', $decrypted);
            if ($tokenUsername != $username) {
                return false;
            }
            if (time() - (int) $time > $this->tokenLifetime) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @return Connection
     */
    protected function getDb()
    {
        return $this->app['db'];
    }

    protected function getEncryptor()
    {
        return new AesEncryptor($this->encryptionKey);
    }

    public function createUser($login, $clearPassword)
    {
        $encryptedPassword = password_hash($clearPassword, PASSWORD_BCRYPT);
        $sql               = 'INSERT INTO users (login, password) VALUES (?, ?);';
        $values            = [$login, $encryptedPassword];
        $this->getDb()->executeUpdate($sql, $values);
    }

    public function deleteUser($login)
    {
        $sql               = 'DELETE FROM users WHERE login=?;';
        $values            = [$login];
        $this->getDb()->executeUpdate($sql, $values);
    }
}
