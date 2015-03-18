<?php

namespace spec\Jmleroux\Api\Entity;

use Jmleroux\Api\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductHydratorSpec extends ObjectBehavior
{
    function it_is_initializable(Application $application)
    {
        $this->beConstructedWith($application);
        $this->shouldHaveType('Jmleroux\Api\Entity\ProductHydrator');
        $this->shouldHaveType('Zend\Stdlib\Hydrator\HydratorInterface');
    }
}
