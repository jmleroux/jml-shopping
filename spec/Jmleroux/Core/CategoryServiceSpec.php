<?php

namespace spec\Jmleroux\Core;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;

class CategoryServiceSpec extends ObjectBehavior
{
    function let(Connection $connection)
    {
        $this->beConstructedWith($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Jmleroux\Core\CategoryService');
    }
}
