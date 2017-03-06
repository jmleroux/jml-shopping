<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\ProductHydrator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function listAction()
    {
        $repo = $this->get('jmlshopping.product');
        $products = $repo->getAll();
        $response = new JsonResponse($products);

        return $response;
    }

    public function viewAction($id)
    {
        $repo = $this->get('jmlshopping.product');
        $product = $repo->getProduct($id);
        $response = new JsonResponse($product);

        return $response;
    }

    public function createAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!$this->validateProductData($data)) {
            return new JsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product = new Product();
        $hydrator = new ProductHydrator($this->get('jmlshopping.category'));
        $hydrator->hydrate($data, $product);

        $repo = $this->get('jmlshopping.product');
        $existingProduct = $repo->findByName($product->getName());

        if (null === $existingProduct) {
            $product = $repo->create($product);
            $response = new JsonResponse($product, Response::HTTP_CREATED);
        } else {
            $response = new JsonResponse($existingProduct, Response::HTTP_IM_USED);
        }

        return $response;
    }

    public function updateAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $hydrator = new ProductHydrator($this->get('jmlshopping.category'));
        $hydrator->hydrate($data, $product);

        $repo = $this->get('jmlshopping.product');
        $product = $repo->update($product);

        $response = new JsonResponse($product);

        return $response;
    }

    public function deleteAction($id)
    {
        $repo = $this->get('jmlshopping.product');
        $product = $repo->remove($id);
        $response = new JsonResponse($product);

        return $response;
    }

    public function truncateAction()
    {
        $repo = $this->get('jmlshopping.product');
        $result = $repo->removeAll();
        $response = new JsonResponse($result);

        return $response;
    }

    private function validateProductData($data)
    {
        if (!isset($data['name']) || empty($data['name'])) {
            return false;
        }

        return true;
    }
}
