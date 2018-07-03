<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function listAction(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->getAll();
        $response = new JsonResponse($products);

        return $response;
    }

    public function viewAction(ProductRepository $productRepository, string $id): JsonResponse
    {
        $product = $productRepository->getProduct($id);
        $response = new JsonResponse($product);

        return $response;
    }

    public function createAction(Request $request, ProductRepository $productRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$this->validateProductData($data)) {
            return new JsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product = Product::create($data['id'], $data['name'], $data['categoryId'], $data['quantity']);
        $existingProduct = $productRepository->findByName($product->getName());

        if (null === $existingProduct) {
            $product = $productRepository->create($product);
            $response = new JsonResponse($product, Response::HTTP_CREATED);
        } else {
            $response = new JsonResponse($existingProduct, Response::HTTP_IM_USED);
        }

        return $response;
    }

    public function updateAction(Request $request, ProductRepository $productRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product = Product::create($data['id'], $data['name'], $data['categoryId'], $data['quantity']);
        $productRepository->update($product);

        $response = new JsonResponse($product);

        return $response;
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

    private function validateProductData(array $data): bool
    {
        if (!isset($data['name']) || empty($data['name'])) {
            return false;
        }

        return true;
    }
}
