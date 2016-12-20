<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Zend\Hydrator\HydratorInterface;

class CategoryHydrator implements HydratorInterface
{
    /**
     * @param Category $category
     *
     * @return array
     */
    public function extract($category)
    {
        return [
            'id'   => $category->getId(),
            'name' => $category->getName(),
        ];
    }

    /**
     * @param array    $data
     * @param Category $category
     *
     * @return Category
     */
    public function hydrate(array $data, $category)
    {
        if (isset($data['id'])) {
            $category->setId($data['id']);
        }
        if (isset($data['name'])) {
            $category->setName($data['name']);
        }

        return $category;
    }
}
