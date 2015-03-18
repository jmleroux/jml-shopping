<?php

namespace spec\Jmleroux\Api\Entity;

use Jmleroux\Api\Entity\Category;
use Jmleroux\Api\Entity\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Api\Entity\Product');
    }

    function it_can_set_id()
    {
        $this->setId(666);
        $this->getId()->shouldReturn(666);

        $this->setId('foo');
        $this->getId()->shouldReturn(0);
    }

    function it_can_set_category(Category $category)
    {
        $this->setCategory($category);
        $this->getCategory()->shouldReturn($category);
    }

    function it_can_set_product()
    {
        $this->setProduct('foo');
        $this->getProduct()->shouldReturn('foo');

        $this->setProduct('   foo  ');
        $this->getProduct()->shouldReturn('foo');
    }

    function it_can_set_quantity()
    {
        $this->setQuantity(666);
        $this->getQuantity()->shouldReturn(666);

        $this->setQuantity('foo');
        $this->getQuantity()->shouldReturn(0);
    }
}
