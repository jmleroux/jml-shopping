<?php
namespace Api\Entity;

class Product
{
    /**
     * @var int
     */
    protected $id = null;
    /**
     * @var Category
     */
    protected $category = null;
    /**
     * @var string
     */
    protected $product = '';
    /**
     * @var int
     */
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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $product
     */
    public function setProduct($product)
    {
        $this->product = trim($product);
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
