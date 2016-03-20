<?php

namespace spec\Jmleroux\Core;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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

    function it_fetches_all_categories($connection)
    {
        $category = [
            'id' => 1,
            'label' => 'foo',
        ];
        $connection->fetchAll(Argument::type('string'))
            ->willReturn([$category]);

        $this->getAll()->shouldReturn([$category]);
    }
}
