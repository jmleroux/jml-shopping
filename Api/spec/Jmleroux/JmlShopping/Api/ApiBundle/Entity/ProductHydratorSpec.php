<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\CategoryService;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\ProductHydrator;
use PhpSpec\ObjectBehavior;

class ProductHydratorSpec extends ObjectBehavior
{
    protected $arrayData = [
        'id'       => 1,
        'name'     => 'foo',
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
        $this->shouldHaveType(ProductHydrator::class);
        $this->shouldImplement('Zend\Hydrator\HydratorInterface');
    }

    function it_can_extract(Product $product, Category $category)
    {
        $product->getId()
            ->shouldBeCalled()
            ->willReturn(1);
        $product->getName()
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
