<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

class ProductSelection
{
    /** @var string */
    protected $id = null;

    /** @var string */
    protected $categoryId = null;

    /** @var string */
    protected $name = '';

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

    private function __construct(string $id, string $name, ?string $categoryId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
    }

    public static function create(?string $id, string $name, ?string $categoryId)
    {
        if (null === $id) {
            $id = uniqid('pid');
        }

        return new self($id, $name, $categoryId);
    }

    public function normalize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->categoryId,
        ];
    }
}
