<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;
use Jmleroux\JmlShopping\Api\ApiBundle\Security\PasswordEncoder;

class UserService
{
    /**
     * @var Connection
     */
    protected $userRepository;

    /**
     * @var string encryption key should be 16, 24 or 32 characters long form 128, 192, 256 bit encryption
     */
    protected $encryptionKey;

    protected $tokenLifetime = 3600;

    /** @var PasswordEncoder */
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, PasswordEncoder $passwordEncoder, $encryptionKey)
    {
        $this->userRepository = $userRepository;
        $this->encryptionKey = $encryptionKey;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param $username
     * @param $password
     *
     * @return array
     */
    public function authenticate($username, $password)
    {
        $user = $this->userRepository->findByUsername($username);

        $authenticationResult = [
            'username' => $username,
            'token'    => '',
        ];

        if (!empty($user)) {
            $verified = $this->passwordEncoder->isPasswordValid($user->getPassword(), $password);
            if ($verified) {
                $authenticationResult['token'] = $this->encryptToken($username);
            }
        }

        return $authenticationResult;
    }

    private function encryptToken($username)
    {
        $key = Key::loadFromAsciiSafeString($this->encryptionKey);
        $token = Crypto::Encrypt($username . '-+-' . time(), $key);

        return $username . '-+-' . base64_encode($token);
    }

    public function decryptToken($token)
    {
        $key = Key::loadFromAsciiSafeString($this->encryptionKey);
        $decrypted = Crypto::Decrypt($token, $key);

        return $decrypted;
    }

    public function tokenIsValid($payload)
    {
        list($username, $base64Token) = explode('-+-', $payload);
        $token = base64_decode($base64Token);
        $key = Key::loadFromAsciiSafeString($this->encryptionKey);
        $decrypted = Crypto::Decrypt($token, $key);
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
}
