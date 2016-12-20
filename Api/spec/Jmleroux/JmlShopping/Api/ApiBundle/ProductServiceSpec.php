<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Statement;
use Jmleroux\JmlShopping\Api\ApiBundle\CategoryService;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\ProductService;
use PDO;
use PhpSpec\ObjectBehavior;

class ProductServiceSpec extends ObjectBehavior
{
    function let(
        Connection $connection,
        CategoryService $categoryService
    ) {
        $this->beConstructedWith($connection, $categoryService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProductService::class);
    }

    function it_fetches_all_products(
        Connection $connection,
        QueryBuilder $qb,
        Statement $statement
    ) {
        $connection->createQueryBuilder()->willReturn($qb);

        $this->prepare_find_query_builder($qb);
        $qb->orderBy('c.label, p.name')->willReturn($qb);
        $qb->execute()->willReturn($statement);
        $statement->fetchAll(PDO::FETCH_ASSOC)->willReturn(['foo']);

        $this->getAll()->shouldReturn(['foo']);
    }

    function it_fetch_one_product(
        Connection $connection,
        QueryBuilder $qb,
        Statement $statement
    ) {
        $row = [
            'id'         => 1,
            'product'    => 'product-label',
            'quantity'   => 666,
            'categoryId' => 10,
            'label'      => 'category-label',
            'category'   => [
                'id'    => 10,
                'label' => 'category-label',
            ],
        ];

        $id = $row['id'];

        $connection->createQueryBuilder()->willReturn($qb);

        $this->prepare_find_query_builder($qb);
        $qb->where('p.id = :productId')->willReturn($qb);
        $qb->setParameter('productId', $id, PDO::PARAM_INT)->willReturn($qb);
        $qb->execute()->willReturn($statement);
        $statement->fetch(PDO::FETCH_ASSOC)->willReturn($row);

        $this->getProduct($id)->shouldReturn($row);
    }

    function it_fetch_one_product_by_name(
        Connection $connection,
        QueryBuilder $qb,
        Statement $statement
    ) {
        $row = [
            'id'         => 1,
            'name'       => 'product-label',
            'quantity'   => 666,
            'categoryId' => 10,
            'label'      => 'category-label',
            'category'   => [
                'id'    => 10,
                'label' => 'category-label',
            ],
        ];

        $name = $row['name'];

        $connection->createQueryBuilder()->willReturn($qb);

        $this->prepare_find_query_builder($qb);
        $qb->where('p.name = :name')->willReturn($qb);
        $qb->setParameter('name', $name, PDO::PARAM_STR)->willReturn($qb);
        $qb->execute()->willReturn($statement);
        $statement->fetch(PDO::FETCH_ASSOC)->willReturn($row);

        $this->findByName($name)->shouldReturn($row);
    }

    function it_removes_all_products(Connection $connection)
    {
        $connection->executeQuery('DELETE FROM products')->shouldBeCalled();
        $this->removeAll()->shouldReturn(null);
    }

    function it_removes_one_product(Connection $connection)
    {
        $connection->executeUpdate('DELETE FROM products WHERE id = ?', [1])->shouldBeCalled();
        $this->remove(1)->shouldReturn(null);
    }

    function it_updates_one_product(Connection $connection)
    {
        $category = new Category();
        $category->setId(11);
        $category->setLabel('fooCat');

        $product = new Product();
        $product->setId(1);
        $product->setName('fooProd');
        $product->setQuantity(2);
        $product->setCategory($category);

        $sql = 'UPDATE products
        SET product = ?, category = ?, quantity = ?
        WHERE id = ?';
        $values = [
            $product->getName(),
            $product->getCategory()->getId(),
            $product->getQuantity(),
            $product->getId(),
        ];
        $connection->executeUpdate($sql, $values)->shouldBeCalled();
        $this->update($product)->shouldReturn(null);
    }

    function it_creates_one_product(Connection $connection)
    {
        $category = new Category();
        $category->setId(11);
        $category->setLabel('fooCat');

        $product = new Product();
        $product->setId(1);
        $product->setName('fooProd');
        $product->setQuantity(2);
        $product->setCategory($category);

        $sql = 'INSERT INTO products (id, name, category_id, quantity)
        VALUES (?, ?, ?, ?)';
        $values = [
            $product->getId(),
            $product->getName(),
            $product->getCategory() ? $product->getCategory()->getId() : null,
            $product->getQuantity(),
        ];
        $connection->executeUpdate($sql, $values)->shouldBeCalled();
        $this->create($product)->shouldReturn(null);
    }

    function it_creates_one_product_without_category(Connection $connection)
    {
        $product = new Product();
        $product->setId(1);
        $product->setName('fooProd');
        $product->setQuantity(2);

        $sql = 'INSERT INTO products (id, name, category_id, quantity)
        VALUES (?, ?, ?, ?)';

        $values = [
            $product->getId(),
            $product->getName(),
            null,
            $product->getQuantity(),
        ];
        $connection->executeUpdate($sql, $values)->shouldBeCalled();
        $this->create($product)->shouldReturn(null);
    }

    function prepare_find_query_builder(QueryBuilder $qb)
    {
        $qb->select('p.id, p.name, p.quantity, c.id AS categoryId, c.label AS category')->willReturn($qb);
        $qb->from(ProductService::TABLENAME, 'p')->willReturn($qb);
        $qb->leftJoin('p', CategoryService::TABLENAME, 'c', 'p.category_id = c.id')->willReturn($qb);

        return $qb;
    }

}
