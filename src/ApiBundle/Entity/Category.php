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

    public function setName(string $name): void
    {
        $this->name = trim($name);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
}
