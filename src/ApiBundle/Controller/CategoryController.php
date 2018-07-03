<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends Controller
{
    public function listAction(CategoryRepository $categoryRepository): JsonResponse
    {
        $categories = $categoryRepository->getAll();
        $response = new JsonResponse($categories);

        return $response;
    }
}
