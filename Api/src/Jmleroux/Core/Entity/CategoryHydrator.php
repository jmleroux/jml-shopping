<?php
namespace Jmleroux\Core\Entity;

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
        /** @var Category $category */
        return [
            'id'    => $category->getId(),
            'label' => $category->getLabel(),
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
        /** @var Category $category */
        if (isset($data['id'])) {
            $category->setId($data['id']);
        }
        if (isset($data['label'])) {
            $category->setLabel($data['label']);
        }

        return $category;
    }
}
