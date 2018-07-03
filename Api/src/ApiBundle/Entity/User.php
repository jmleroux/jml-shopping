<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /** @var string */
    private $uid;
    /** @var string */
    private $login;
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
        return $this->login;
    }

    public function eraseCredentials()
    {
        $this->password = '';
    }

    private function __construct(string $uuid, string $username, string $password)
    {
        $this->uid = $uuid;
        $this->login = $username;
        $this->password = $password;
    }

    public static function create(string $uuid, string $username, string $password): User
    {
        return new self($uuid, $username, $password);
    }

    public static function newUser(string $username, string $password): User
    {
        $uuid = Uuid::uuid4()->toString();
        return new self($uuid, $username, $password);
    }
}
