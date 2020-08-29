<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Controller;

use Jmleroux\JmlShopping\Api\ApiBundle\Application\CreateOrEditCategoryCommand;
use Jmleroux\JmlShopping\Api\ApiBundle\Application\CreateOrEditCategoryHandler;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    public function listAction(CategoryRepository $categoryRepository): JsonResponse
    {
        $categories = $categoryRepository->getAll();

        return new JsonResponse($categories);
    }

    public function createAction(
        Request $request,
        CreateOrEditCategoryHandler $createOrEditCategoryHandler
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name']) || empty($data['name'])) {
            return new JsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $command = new CreateOrEditCategoryCommand();
        $command->categoryData = $data;
        $product = $createOrEditCategoryHandler->execute($command);

        return new JsonResponse($product);
    }


    public function deleteAction(CategoryRepository $categoryRepository, string $id): JsonResponse
    {
        $product = $categoryRepository->remove($id);

        return new JsonResponse($product);
    }
}
