<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Application\CreateOrEditProductCommand;
use Jmleroux\JmlShopping\Api\ApiBundle\Application\CreateOrEditProductHandler;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    public function listAction(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->getAll();
        $response = new JsonResponse($products);

        return $response;
    }

    public function createAction(Request $request, CreateOrEditProductHandler $createOrEditProductHandler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name']) || empty($data['name'])) {
            return new JsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $command = new CreateOrEditProductCommand();
        $command->productData = $data;
        $product = $createOrEditProductHandler->execute($command);

        return new JsonResponse($product);
    }

    public function deleteAction(ProductRepository $productRepository, string $id): JsonResponse
    {
        $product = $productRepository->remove($id);
        $response = new JsonResponse($product);

        return $response;
    }

    public function truncateAction(ProductRepository $productRepository): JsonResponse
    {
        $productRepository->removeAll();

        return new JsonResponse();
    }
}
