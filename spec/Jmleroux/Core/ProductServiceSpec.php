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
    )
    {
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

    function it_fetch_one_products($connection)
    {
        $row = [
            'id' => 1,
            'product' => 'product-label',
            'quantity' => 666,
            'categoryId' => 10,
            'label' => 'category-label',
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

    function it_removes_one_product($connection)
    {
        $connection->executeUpdate('DELETE FROM products WHERE id = ?', [1])->shouldBeCalled();
        $this->remove(1)->shouldReturn(null);
    }

    function it_updates_one_product(Product $product, Category $category, $connection)
    {
        $category->getId()->willReturn(99);

        $product->getId()->willReturn(1);
        $product->getProduct()->willReturn('foobar');
        $product->getQuantity()->willReturn(2);
        $product->getCategory()->willReturn($category);

        $values = ['foobar', 99, 2, 1];
        $connection->executeUpdate(Argument::any(), $values)->shouldBeCalled();

        $this->update($product)->shouldReturn(null);
    }

    function it_creates_one_product(Product $product, Category $category, $connection)
    {
        $category->getId()->willReturn(99);

        $product->getId()->willReturn(1);
        $product->getProduct()->willReturn('foobar');
        $product->getQuantity()->willReturn(2);
        $product->getCategory()->willReturn($category);

        $values = ['foobar', 99, 2];
        $connection->executeUpdate(Argument::any(), $values)->shouldBeCalled();

        $this->create($product)->shouldReturn(null);
    }

    function it_creates_one_product_without_category(Product $product, $connection)
    {
        $product->getId()->willReturn(1);
        $product->getProduct()->willReturn('foobar');
        $product->getQuantity()->willReturn(2);
        $product->getCategory()->willReturn(null);

        $values = ['foobar', null, 2];
        $connection->executeUpdate(Argument::any(), $values)->shouldBeCalled();

        $this->create($product)->shouldReturn(null);
    }
}
