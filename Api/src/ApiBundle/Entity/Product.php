<?php

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

    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = trim($name);
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
