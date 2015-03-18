<?php

namespace spec\Jmleroux\Api\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CategorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Api\Entity\Category');
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
        $this->setLabel('foo');
        $this->getLabel()->shouldReturn('foo');

        $this->setLabel('  foo   ');
        $this->getLabel()->shouldReturn('foo');
    }
}