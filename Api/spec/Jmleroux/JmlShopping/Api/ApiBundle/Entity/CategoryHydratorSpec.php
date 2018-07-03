<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Entity;

use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\CategoryHydrator;
use PhpSpec\ObjectBehavior;
use Zend\Hydrator\HydratorInterface;

class CategoryHydratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CategoryHydrator::class);
        $this->shouldImplement(HydratorInterface::class);
    }

    function it_can_extract(Category $category)
    {
        $category->getId()
            ->shouldBeCalled()
            ->willReturn('uuid');
        $category->getName()
            ->shouldBeCalled()
            ->willReturn('foo');

        $output = [
            'id' => 'uuid',
            'name' => 'foo',
        ];

        $this->extract($category)->shouldReturn($output);
    }

    function it_can_hydrate(Category $category)
    {
        $input = [
            'id' => 'uuid',
            'name' => 'foo',
        ];

        $category->setId('uuid')
            ->shouldBeCalled();
        $category->setName('foo')
            ->shouldBeCalled();

        $this->hydrate($input, $category)->shouldReturn($category);
    }
}
