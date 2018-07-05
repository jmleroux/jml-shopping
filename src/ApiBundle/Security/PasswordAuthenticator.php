<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Jmleroux\JmlShopping\Api\ApiBundle\Repository\UserRepository;

class PasswordAuthenticator
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var string encryption key should be 16, 24 or 32 characters long form 128, 192, 256 bit encryption
     */
    protected $encryptionKey;

    protected $tokenLifetime = 3600;

    /** @var PasswordEncoder */
    private $passwordEncoder;

    /** @var TokenEncoder */
    private $tokenEncoder;

    public function __construct(
        UserRepository $userRepository,
        PasswordEncoder $passwordEncoder,
        TokenEncoder $tokenEncoder,
        string $encryptionKey
    ) {
        $this->userRepository = $userRepository;
        $this->encryptionKey = $encryptionKey;
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenEncoder = $tokenEncoder;
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
            'token' => '',
        ];

        if (!empty($user)) {
            $verified = $this->passwordEncoder->isPasswordValid($user->getPassword(), $password);
            if ($verified) {
                $authenticationResult['token'] = $this->tokenEncoder->encryptToken($username);
            }
        }

        return $authenticationResult;
    }
}
