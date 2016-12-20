<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\CategoryHydrator;
use PhpSpec\ObjectBehavior;

class CategoryHydratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CategoryHydrator::class);
        $this->shouldImplement('Zend\Hydrator\HydratorInterface');
    }

    function it_can_extract(Category $category)
    {
        $category->getId()
            ->shouldBeCalled()
            ->willReturn(666);
        $category->getName()
            ->shouldBeCalled()
            ->willReturn('foo');

        $output = [
            'id' => 666,
            'name' => 'foo',
        ];

        $this->extract($category)->shouldReturn($output);
    }

    function it_can_hydrate(Category $category)
    {
        $input = [
            'id' => 666,
            'name' => 'foo',
        ];

        $category->setId(666)
            ->shouldBeCalled();
        $category->setName('foo')
            ->shouldBeCalled();

        $this->hydrate($input, $category)->shouldReturn($category);
    }
}
