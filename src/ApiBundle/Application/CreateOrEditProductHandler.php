<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Application;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\ProductRepository;

class CreateOrEditProductHandler
{
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(CreateOrEditProductCommand $command): Product
    {
        $data = $command->productData;

        $product = Product::create($data['id'], $data['name'], $data['category_id'], $data['quantity']);
        $existingProduct = $this->productRepository->findByName($product->getName());

        if (null === $existingProduct) {
            $result = $this->productRepository->create($product);
        } else {
            $result = $this->productRepository->update($product);
        }

        if (0 === $result) {
            throw new \RuntimeException('Unable to edit product');
        }

        return $product;
    }
}
