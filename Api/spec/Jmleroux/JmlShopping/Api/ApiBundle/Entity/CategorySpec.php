<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use PhpSpec\ObjectBehavior;

class CategorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Category::class);
    }

    function it_can_set_id()
    {
        $this->setId(666);
        $this->getId()->shouldReturn(666);

        $this->setId('foo');
        $this->getId()->shouldReturn(0);
    }

    function it_can_set_label()
    {
        $this->setName('foo');
        $this->getName()->shouldReturn('foo');

        $this->setName('  foo   ');
        $this->getName()->shouldReturn('foo');
    }
}
