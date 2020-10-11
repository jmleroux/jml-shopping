<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CategorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Category::class);
    }

    function it_can_be_created_with_id()
    {
        $this->beConstructedThrough('create', ['category_id', 'category_name']);
        $this->getId()->shouldReturn('category_id');
        $this->getName()->shouldReturn('category_name');
    }

    function it_can_have_null_id()
    {
        $this->beConstructedThrough('create', [null, 'category_name']);
        $this->getId()->shouldBeString();
    }
}
