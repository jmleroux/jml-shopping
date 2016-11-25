<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
}
