<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use PhpSpec\ObjectBehavior;

class ProductSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('create', [
            'pid',
            'foo',
            'cid',
            666,
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Product::class);
    }

    function it_can_get_id()
    {
        $this->getId()->shouldReturn('pid');
    }

    function it_can_set_name()
    {
        $this->getName()->shouldReturn('foo');
        $this->getName()->shouldReturn('foo');
    }

    function it_can_set_quantity()
    {
        $this->getQuantity()->shouldReturn(666);
    }
}
