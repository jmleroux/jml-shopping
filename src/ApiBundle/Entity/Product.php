<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

class Product
{
    /** @var string */
    protected $id = null;

    /** @var string */
    protected $categoryId = null;

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

    public function getId(): string
    {
        return $this->id;
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

    private function __construct(string $id, string $name, string $categoryId, int $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->quantity = $quantity;
    }

    public static function create(string $id, string $name, string $categoryId, int $quantity)
    {
        return new self($id, $name, $categoryId, $quantity);
    }
}
