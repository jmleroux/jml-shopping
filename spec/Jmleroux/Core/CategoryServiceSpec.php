<?php

namespace spec\Jmleroux\Core;

use Doctrine\DBAL\Connection;
use Jmleroux\Core\Entity\Category;
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

    function it_can_get_hydrator()
    {
        $this->getHydrator()->shouldHaveType('Jmleroux\Core\Entity\CategoryHydrator');
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

    function it_fetch_one_category($connection)
    {
        $row = [
            'id' => 1,
            'label' => 'category-label',
        ];

        $connection->fetchAssoc(Argument::type('string'), Argument::type('array'))
            ->willReturn($row);

        $this->getCategory(1)->shouldHaveType('Jmleroux\Core\Entity\Category');
    }

    function it_removes_one_category($connection)
    {
        $connection->executeUpdate('DELETE FROM categories WHERE id = ?', [1])->shouldBeCalled();
        $this->remove(1)->shouldReturn(null);
    }

    function it_creates_one_category(Category $category, $connection)
    {
        $category->getLabel()->willReturn('foobar');

        $values = ['foobar'];
        $connection->executeUpdate(Argument::any(), $values)->shouldBeCalled();

        $this->create($category)->shouldReturn(null);
    }

    function it_updates_one_category(Category $category, $connection)
    {
        $category->getId()->willReturn(99);
        $category->getLabel()->willReturn('foobar');

        $values = ['foobar', 99];
        $connection->executeUpdate(Argument::any(), $values)->shouldBeCalled();

        $this->update($category)->shouldReturn(null);
    }
}
