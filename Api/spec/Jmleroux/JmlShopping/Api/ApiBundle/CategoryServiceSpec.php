<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\CategoryService;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\CategoryHydrator;
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
        $this->shouldHaveType(CategoryService::class);
    }

    function it_get_category_hydrator()
    {
        $this->getHydrator()->shouldHaveType(CategoryHydrator::class);
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

        $this->findById(1)->shouldHaveType(Category::class);
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
