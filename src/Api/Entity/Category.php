<?php
namespace Api\Entity;

class Category
{
    /**
     * @var int
     */
    protected $id = null;
    /**
     * @var string
     */
    protected $label = '';

    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
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
