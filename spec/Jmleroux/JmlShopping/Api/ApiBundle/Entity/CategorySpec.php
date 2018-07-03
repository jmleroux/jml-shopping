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
        $this->setId('uuid');
        $this->getId()->shouldReturn('uuid');
    }

    function it_can_set_label()
    {
        $this->setName('foo');
        $this->getName()->shouldReturn('foo');

        $this->setName('  foo   ');
        $this->getName()->shouldReturn('foo');
    }
}
