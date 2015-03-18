<?php

namespace spec\Jmleroux\Api\Entity;

use Jmleroux\Api\Application;
use Jmleroux\Api\CategoryService;
use Jmleroux\Api\Entity\Category;
use Jmleroux\Api\Entity\CategoryHydrator;
use Jmleroux\Api\Entity\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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

    function let(Application $application)
    {
        $this->beConstructedWith($application);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Api\Entity\ProductHydrator');
        $this->shouldHaveType('Zend\Stdlib\Hydrator\HydratorInterface');
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

    function it_can_hydrate(
        $application,
        Product $product,
        Category $category,
        CategoryService $categoryService,
        CategoryHydrator $categoryHydrator
    ) {
//        $category->setId(2)
//            ->shouldBeCalled();
//        $category->setLabel('category')
//            ->shouldBeCalled();
//
//        $application['category_service']->willReturn($categoryService);
//        $categoryService->getHydrator()->willReturn($categoryHydrator);
//
//        $product->setId(1)
//            ->shouldBeCalled();
//        $product->setProduct('foo')
//            ->shouldBeCalled();
//        $product->setQuantity(666)
//            ->shouldBeCalled();
//        $product->setCategory($category)
//            ->shouldBeCalled();
//
//        $this->hydrate($this->arrayData, $product)->shouldReturn($product);
    }
}
