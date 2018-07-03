<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\Repository\CategoryRepository;
use Zend\Hydrator\HydratorInterface;

class ProductHydrator implements HydratorInterface
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
        if (isset($data['quantity'])) {
            $product->setQuantity($data['quantity']);
        }
        if (isset($data['category'])) {
            $category = $this->categoryRepository->getHydrator()->hydrate($data['category'], new Category());
            $product->setCategory($category);
        } elseif (isset($data['category_id'])) {
            $category = $this->categoryRepository->findById($data['category_id']);
            $product->setCategory($category);
        }

        return $product;
    }
}
