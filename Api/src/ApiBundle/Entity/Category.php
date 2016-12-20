<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

class Category
{
    /** @var int */
    protected $id = null;

    /** @var string */
    protected $name = '';

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = trim($name);
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }
}
