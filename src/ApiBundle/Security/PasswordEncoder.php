<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Security;

use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PasswordEncoder
{
    private const SALT = 'foo';

    /** @var PasswordEncoderInterface */
    private $encoder;

    public function __construct()
    {
        $this->encoder = new BCryptPasswordEncoder(10);
    }

    public function encodePlainPassword(string $password): string
    {
        return $this->encoder->encodePassword($password, self::SALT);
    }

    public function isPasswordValid(string $encoded, string $raw): bool
    {
        return $this->encoder->isPasswordValid($encoded, $raw, self::SALT);
    }
}
