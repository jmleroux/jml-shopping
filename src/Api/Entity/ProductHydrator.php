<?php
namespace Api\Entity;

use Api\CategoryService;
use Silex;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ProductHydrator implements HydratorInterface
{
    /**
     * @var Silex\Application
     */
    protected $app;

    public function __construct(Silex\Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Product $product
     * @return array
     */
    public function extract($product)
    {
        return array(
            'id'       => $product->getId(),
            'product'  => $product->getProduct(),
            'quantity' => $product->getQuantity(),
            'category' => $product->getCategory()->extract(),
        );
    }

    /**
     * @param array   $data
     * @param Product $product
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
            /** @var CategoryService $categoryService */
            $categoryService = $this->app['category_service'];
            $category        = $categoryService->getHydrator()->hydrate($data['category'], new Category());
            $product->setCategory($category);
        }
        if (isset($data['quantity'])) {
            $product->setQuantity($data['quantity']);
        }

        return $product;
    }
}