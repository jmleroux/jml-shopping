<?php

namespace spec\Jmleroux\Core;

use Doctrine\DBAL\Connection;
use Jmleroux\Core\CategoryService;
use Jmleroux\Core\Entity\Category;
use Jmleroux\Core\Entity\CategoryHydrator;
use Jmleroux\Core\Entity\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductServiceSpec extends ObjectBehavior
{
    function let(
        Connection $connection,
        CategoryService $categoryService,
        CategoryHydrator $categoryHydrator,
        Category $category
    ) {
        $categoryService->getHydrator()->willReturn($categoryHydrator);
        $categoryHydrator->hydrate(Argument::type('array'), new Category())
            ->willReturn($category);
        $this->beConstructedWith($connection, $categoryService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Core\ProductService');
    }

    function it_can_get_hydrator()
    {
        $this->getHydrator()->shouldHaveType('Jmleroux\Core\Entity\ProductHydrator');
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

        $this->getProduct(1)->shouldHaveType('Jmleroux\Core\Entity\Product');
    }

    function it_removes_all_products($connection)
    {
        $connection->executeQuery('DELETE FROM products')->shouldBeCalled();
        $this->removeAll()->shouldReturn(null);
    }
}
