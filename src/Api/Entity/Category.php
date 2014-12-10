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

    /**
     * @return string
     */
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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function extract()
    {
        return array(
            'id'    => $this->getId(),
            'label' => $this->getLabel(),
        );
    }
}
