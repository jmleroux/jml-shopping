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
        $existingProductData = $this->productRepository->findByName($data['name']);

        if (null === $existingProductData) {
            $product = Product::create($data['id'], $data['name'], $data['category_id'], $data['quantity']);
            $result = $this->productRepository->create($product);
        } else {
            $product = Product::create(
                $existingProductData['id'],
                $data['name'],
                $data['category_id'],
                $data['quantity']
            );
            $result = $this->productRepository->update($product);
        }

        if (0 === $result) {
            throw new \RuntimeException('Unable to edit product');
        }

        return $product;
    }
}
