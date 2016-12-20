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

    function it_get_category_hydrator()
    {
        $this->getHydrator()->shouldHaveType(CategoryHydrator::class);
    }

    function it_fetches_all_categories(Connection $connection)
    {
        $category = [
            'id'   => 1,
            'name' => 'foo',
        ];
        $connection->fetchAll(Argument::type('string'))
            ->willReturn([$category]);

        $this->getAll()->shouldReturn([$category]);
    }

    function it_fetch_one_category(Connection $connection)
    {
        $row = [
            'id'   => 1,
            'name' => 'category-name',
        ];

        $connection->fetchAssoc(Argument::type('string'), Argument::type('array'))
            ->willReturn($row);

        $this->findById(1)->shouldHaveType(Category::class);
    }

    function it_removes_one_category(Connection $connection)
    {
        $connection->executeUpdate('DELETE FROM categories WHERE id = ?', [1])->shouldBeCalled();
        $this->remove(1)->shouldReturn(null);
    }

    function it_creates_one_category(Category $category, Connection $connection)
    {
        $category->getName()->willReturn('foobar');

        $values = ['foobar'];
        $connection->executeUpdate(Argument::any(), $values)->shouldBeCalled();

        $this->create($category)->shouldReturn(null);
    }

    function it_updates_one_category(Category $category, Connection $connection)
    {
        $category->getId()->willReturn(99);
        $category->getName()->willReturn('foobar');

        $values = ['foobar', 99];
        $connection->executeUpdate(Argument::any(), $values)->shouldBeCalled();

        $this->update($category)->shouldReturn(null);
    }
}
