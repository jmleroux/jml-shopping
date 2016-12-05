<?php

namespace spec\Jmleroux\Core\Entity;

use Jmleroux\Core\CategoryService;
use Jmleroux\Core\Entity\Category;
use Jmleroux\Core\Entity\Product;
use PhpSpec\ObjectBehavior;

class ProductHydratorSpec extends ObjectBehavior
{
    protected $arrayData = [
        'id'       => 1,
        'product'  => 'foo',
        'quantity' => 666,
        'category' => [
            'id'    => 2,
            'label' => 'category',
        ],
    ];

    function let(CategoryService $categoryService)
    {
        $this->beConstructedWith($categoryService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Core\Entity\ProductHydrator');
        $this->shouldImplement('Zend\Hydrator\HydratorInterface');
    }

    function it_can_extract(Product $product, Category $category)
    {
        $product->getId()
            ->shouldBeCalled()
            ->willReturn(1);
        $product->getProduct()
            ->shouldBeCalled()
            ->willReturn('foo');
        $product->getQuantity()
            ->shouldBeCalled()
            ->willReturn(666);
        $product->getCategory()
            ->shouldBeCalled()
            ->willReturn($category);
        $category->getId()
            ->shouldBeCalled()
            ->willReturn(2);
        $category->getLabel()
            ->shouldBeCalled()
            ->willReturn('category');

        $this->extract($product)->shouldReturn($this->arrayData);
    }
}
