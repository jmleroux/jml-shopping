<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Application;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\CategoryRepository;

class CreateOrEditCategoryHandler
{
    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(CreateOrEditCategoryCommand $command): Category
    {
        $data = $command->categoryData;

        $category = Category::create($data['id'], $data['name']);
        $existingCategory = $this->categoryRepository->findById($category->getId());

        if (null === $existingCategory) {
            $result = $this->categoryRepository->create($category);
        } else {
            $result = $this->categoryRepository->update($category);
        }

        if (0 === $result) {
            throw new \RuntimeException('Unable to edit product');
        }

        return $category;
    }
}
