<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

class Product
{
    /** @var string */
    protected $id = null;

    /** @var Category */
    protected $category = null;

    /** @var string */
    protected $name = '';

    /** @var int */
    protected $quantity = 0;

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = trim($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
