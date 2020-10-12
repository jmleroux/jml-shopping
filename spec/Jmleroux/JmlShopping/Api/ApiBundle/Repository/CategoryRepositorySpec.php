<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Repository;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\CategoryHydrator;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\CategoryRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CategoryRepositorySpec extends ObjectBehavior
{
    function let(Connection $connection)
    {
        $this->beConstructedWith($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CategoryRepository::class);
    }

    function it_fetches_all_categories(Connection $connection)
    {
        $category = [
            'id'   => 'uuid',
            'name' => 'foo',
        ];
        $connection->fetchAll(Argument::type('string'))
            ->willReturn([$category]);

        $this->getAll()->shouldReturn([$category]);
    }

    function it_fetch_one_category(Connection $connection)
    {
        $row = [
            'id'   => 'uuid',
            'name' => 'category-name',
        ];

        $connection->fetchAssoc(Argument::type('string'), Argument::type('array'))
            ->willReturn($row);

        $this->findById('uuid')->shouldHaveType(Category::class);
    }

    function it_removes_one_category(Connection $connection)
    {
        $connection->executeUpdate('DELETE FROM categories WHERE id = ?', ['uuid'])->willReturn(1);
        $this->remove('uuid')->shouldReturn(1);
    }

    function it_creates_one_category(Category $category, Connection $connection)
    {
        $category->getId()->willReturn('uuid');
        $category->getName()->willReturn('foobar');

        $values = ['uuid', 'foobar'];
        $connection->executeUpdate(Argument::any(), $values)->willReturn(1);

        $this->create($category)->shouldReturn(1);
    }

    function it_updates_one_category(Category $category, Connection $connection)
    {
        $category->getId()->willReturn('uuid');
        $category->getName()->willReturn('foobar');

        $values = ['foobar', 'uuid'];
        $connection->executeUpdate(Argument::any(), $values)->willReturn(1);

        $this->update($category)->shouldReturn(1);
    }
}
