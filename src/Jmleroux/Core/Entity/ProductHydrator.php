<?php
namespace Jmleroux\Core\Entity;

use Jmleroux\Core\CategoryService;
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
            'product'  => $product->getProduct(),
            'quantity' => $product->getQuantity(),
            'category' => $categoryHydrator->extract($product->getCategory()),
        ];
    }

    /**
     * @param array   $data
     * @param Product $product
     *
     * @return object
     */
    public function hydrate(array $data, $product)
    {
        if (isset($data['id'])) {
            $product->setId($data['id']);
        }
        if (isset($data['product'])) {
            $product->setProduct($data['product']);
        }
        if (isset($data['category'])) {
            $category = $this->categoryService->getHydrator()->hydrate($data['category'], new Category());
            $product->setCategory($category);
        }
        if (isset($data['quantity'])) {
            $product->setQuantity($data['quantity']);
        }

        return $product;
    }
}
