<?php

namespace spec\Jmleroux\Api;

use Doctrine\DBAL\Connection;
use Jmleroux\Api\CategoryService;
use Jmleroux\Api\Entity\Category;
use Jmleroux\Api\Entity\CategoryHydrator;
use Jmleroux\Api\Entity\Product;
use Jmleroux\Api\Entity\ProductHydrator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Silex\Application;

class ProductServiceSpec extends ObjectBehavior
{
    function let(
        Application $application,
        Connection $connection,
        CategoryService $categoryService,
        CategoryHydrator $categoryHydrator,
        Category $category
    ) {
        $application->offsetGet('db')->willReturn($connection);
        $application->offsetGet('category_service')->willReturn($categoryService);
        $categoryService->getHydrator()->willReturn($categoryHydrator);
        $categoryHydrator->hydrate(Argument::type('array'), new Category())
            ->willReturn($category);
        $this->beConstructedWith($application);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Api\ProductService');
    }

    function it_can_get_hydrator()
    {
        $this->getHydrator()->shouldHaveType('Jmleroux\Api\Entity\ProductHydrator');
    }

    function it_fetches_all_products(Product $product, $connection)
    {
        $connection->fetchAll(Argument::type('string'))
            ->willReturn([$product]);

        $this->getAll()->shouldReturn([$product]);
    }

    function it_fetch_one_products(
        $connection
    ) {
        $row = [
            'id'         => 1,
            'product'    => 'product-label',
            'quantity'   => 666,
            'categoryId' => 10,
            'label'      => 'category-label',
        ];

        $connection->fetchAssoc(Argument::type('string'), Argument::type('array'))
            ->willReturn($row);

        $this->getProduct(1)->shouldHaveType('Jmleroux\Api\Entity\Product');
    }

    function it_removes_all_products($connection)
    {
        $connection->executeQuery('DELETE FROM products')->shouldBeCalled();
        $this->removeAll()->shouldReturn(null);
    }
}
