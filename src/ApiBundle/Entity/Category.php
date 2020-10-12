<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

class Category
{
    /** @var string */
    protected $id = null;

    /** @var string */
    protected $name = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    private function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create(?string $id, string $name)
    {
        if (null === $id) {
            $id = uniqid('cid-');
        }

        return new self($id, $name);
    }
}
