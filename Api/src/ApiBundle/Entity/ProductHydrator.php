<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\CategoryService;
use Zend\Hydrator\HydratorInterface;

class ProductHydrator implements HydratorInterface
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @param Product $product
     *
     * @return array
     */
    public function extract($product)
    {
        $categoryHydrator = new CategoryHydrator();

        return [
            'id'       => $product->getId(),
            'name'     => $product->getName(),
            'quantity' => $product->getQuantity(),
            'category' => $categoryHydrator->extract($product->getCategory()),
        ];
    }

    /**
     * @param array   $data
     * @param Product $product
     *
     * @return Product
     */
    public function hydrate(array $data, $product)
    {
        if (isset($data['id'])) {
            $product->setId($data['id']);
        }
        if (isset($data['name'])) {
            $product->setName($data['name']);
        }
        if (isset($data['category'])) {
            $category = $this->categoryService->getHydrator()->hydrate($data['category'], new Category());
            $product->setCategory($category);
        }
        if (isset($data['category_id'])) {
            $category = $this->categoryService->findById($data['category_id']);
            $product->setCategory($category);
        }
        if (isset($data['quantity'])) {
            $product->setQuantity($data['quantity']);
        }

        return $product;
    }
}
