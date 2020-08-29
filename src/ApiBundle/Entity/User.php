<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /** @var string */
    private $username;
    /** @var string */
    private $password;

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        $this->password = '';
    }

    private function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function create(string $username, string $password): User
    {
        return new self($username, $password);
    }
}
