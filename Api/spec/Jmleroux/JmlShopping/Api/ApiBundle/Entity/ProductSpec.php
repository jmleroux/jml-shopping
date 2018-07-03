<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use PhpSpec\ObjectBehavior;

class ProductSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Product::class);
    }

    function it_can_set_id()
    {
        $this->setId('uuid');
        $this->getId()->shouldReturn('uuid');

        $this->setId('foo');
        $this->getId()->shouldReturn('foo');
    }

    function it_can_set_category(Category $category)
    {
        $this->setCategory($category);
        $this->getCategory()->shouldReturn($category);
    }

    function it_can_set_name()
    {
        $this->setName('foo');
        $this->getName()->shouldReturn('foo');

        $this->setName('   foo  ');
        $this->getName()->shouldReturn('foo');
    }

    function it_can_set_quantity()
    {
        $this->setQuantity(666);
        $this->getQuantity()->shouldReturn(666);
    }
}
