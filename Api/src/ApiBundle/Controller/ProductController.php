<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\ProductHydrator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
        $repo = $this->get('jmlshopping.product');
        $data = json_decode($request->getContent(), true);
        $product = new Product();
        $hydrator = new ProductHydrator($this->get('jmlshopping.category'));
        $hydrator->hydrate($data, $product);
        $product = $repo->create($product);
        $response = new JsonResponse($product);

        return $response;
    }

    public function updateAction(Request $request)
    {
        $repo = $this->get('jmlshopping.product');
        $product = $repo->update([]);
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
}
