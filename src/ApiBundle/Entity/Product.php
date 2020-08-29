<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

class Product
{
    /** @var string */
    protected $id = null;

    /** @var string */
    protected $categoryId = null;

    /** @var string */
    protected $name = '';

    /** @var int */
    protected $quantity = 0;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    private function __construct(string $id, string $name, ?string $categoryId, int $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->quantity = $quantity;
    }

    public static function create(?string $id, string $name, ?string $categoryId, int $quantity)
    {
        if (null === $id) {
            $id = uniqid('pid');
        }

        return new self($id, $name, $categoryId, $quantity);
    }
}
