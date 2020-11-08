<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Application\CreateOrEditProductCommand;
use Jmleroux\JmlShopping\Api\ApiBundle\Application\CreateOrEditProductHandler;
use Jmleroux\JmlShopping\Api\ApiBundle\Application\CreateProductSelectionCommand;
use Jmleroux\JmlShopping\Api\ApiBundle\Application\CreateProductSelectionHandler;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\ProductSelectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductSelectionController extends AbstractController
{
    public function listAction(ProductSelectionRepository $repository): JsonResponse
    {
        $products = $repository->findAll();

        return new JsonResponse($products);
    }

    public function createAction(
        Request $request,
        CreateProductSelectionHandler $createProductSelectionHandler
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name']) || empty($data['name']) || empty($data['category_id'])) {
            return new JsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $command = new CreateProductSelectionCommand();
        $command->productData = $data;
        $product = $createProductSelectionHandler->execute($command);

        return new JsonResponse($product->normalize());
    }

    public function deleteAction(ProductSelectionRepository $repository, string $id): JsonResponse
    {
        $product = $repository->remove($id);

        return new JsonResponse($product);
    }

    public function addSelectionToList(
        Request $request,
        ProductSelectionRepository $repository,
        CreateOrEditProductHandler $createOrEditProductHandler
    ): JsonResponse {
        $ids = json_decode($request->getContent(), true)['ids'];
        $selectedProducts = $repository->findByIds($ids);

        foreach ($selectedProducts as $selectedProduct) {
            $selectedProduct['quantity'] = 0;
            $command = new CreateOrEditProductCommand();
            $command->productData = $selectedProduct;
            $createOrEditProductHandler->execute($command);
        }

        return new JsonResponse($selectedProducts);
    }
}
