<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Application;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\ProductSelection;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\ProductSelectionRepository;

class CreateProductSelectionHandler
{
    /** @var ProductSelectionRepository */
    private $repository;

    public function __construct(ProductSelectionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateProductSelectionCommand $command): ProductSelection
    {
        $data = $command->productData;
        $product = ProductSelection::create($data['id'], $data['name'], $data['category_id']);

        $result = $this->repository->create($product);

        if (0 === $result) {
            throw new \RuntimeException('Unable to create product selection');
        }

        return $product;
    }
}
