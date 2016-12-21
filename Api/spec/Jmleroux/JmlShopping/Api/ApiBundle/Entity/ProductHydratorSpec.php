<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\ProductHydrator;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\CategoryRepository;
use PhpSpec\ObjectBehavior;

class ProductHydratorSpec extends ObjectBehavior
{
    protected $arrayData = [
        'id'       => 1,
        'name'     => 'foo',
        'quantity' => 666,
        'category' => [
            'id'   => 2,
            'name' => 'category',
        ],
    ];

    function let(CategoryRepository $categoryRepository)
    {
        $this->beConstructedWith($categoryRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProductHydrator::class);
        $this->shouldImplement('Zend\Hydrator\HydratorInterface');
    }

    function it_can_extract(Product $product, Category $category)
    {
        $product->getId()->willReturn(1);
        $product->getName()->willReturn('foo');
        $product->getQuantity()->willReturn(666);
        $product->getCategory()->willReturn($category);
        $category->getId()->willReturn(2);
        $category->getName()->willReturn('category');

        $this->extract($product)->shouldReturn($this->arrayData);
    }
}
