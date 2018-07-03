<?php

namespace spec\Jmleroux\JmlShopping\Api\ApiBundle\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Statement;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\CategoryRepository;
use Jmleroux\JmlShopping\Api\ApiBundle\Repository\ProductRepository;
use PDO;
use PhpSpec\ObjectBehavior;

class ProductRepositorySpec extends ObjectBehavior
{
    function let(
        Connection $connection,
        CategoryRepository $categoryRepository
    ) {
        $this->beConstructedWith($connection, $categoryRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProductRepository::class);
    }

    function it_fetches_all_products(
        Connection $connection,
        QueryBuilder $qb,
        Statement $statement
    ) {
        $connection->createQueryBuilder()->willReturn($qb);

        $this->prepare_find_query_builder($qb);
        $qb->orderBy('c.name, p.name')->willReturn($qb);
        $qb->execute()->willReturn($statement);
        $statement->fetchAll(PDO::FETCH_ASSOC)->willReturn(['foo']);

        $this->getAll()->shouldReturn(['foo']);
    }

    function it_fetch_one_product(
        Connection $connection,
        QueryBuilder $qb,
        Statement $statement
    ) {
        $row = $this->get_row_fixture();
        $product = $this->get_product_fixture();
        $id = $row['id'];

        $connection->createQueryBuilder()->willReturn($qb);

        $this->prepare_find_query_builder($qb);
        $qb->where('p.id = :productId')->willReturn($qb);
        $qb->setParameter('productId', $id, PDO::PARAM_STR)->willReturn($qb);
        $qb->execute()->willReturn($statement);
        $statement->fetch(PDO::FETCH_ASSOC)->willReturn($row);

        $this->getProduct($id)->shouldReturn($product);
    }

    function it_returns_null_for_unknown_product(
        Connection $connection,
        QueryBuilder $qb,
        Statement $statement
    ) {
        $id = 'unknown_uuid';

        $connection->createQueryBuilder()->willReturn($qb);

        $this->prepare_find_query_builder($qb);
        $qb->where('p.id = :productId')->willReturn($qb);
        $qb->setParameter('productId', $id, PDO::PARAM_STR)->willReturn($qb);
        $qb->execute()->willReturn($statement);
        $statement->fetch(PDO::FETCH_ASSOC)->willReturn(false);

        $this->getProduct($id)->shouldReturn(null);
    }

    function it_fetch_one_product_by_name(
        Connection $connection,
        QueryBuilder $qb,
        Statement $statement
    ) {
        $row = $this->get_row_fixture();
        $product = $this->get_product_fixture();
        $name = $row['name'];

        $connection->createQueryBuilder()->willReturn($qb);

        $this->prepare_find_query_builder($qb);
        $qb->where('p.name = :name')->willReturn($qb);
        $qb->setParameter('name', $name, PDO::PARAM_STR)->willReturn($qb);
        $qb->execute()->willReturn($statement);
        $statement->fetch(PDO::FETCH_ASSOC)->willReturn($row);

        $this->findByName($name)->shouldReturn($product);
    }

    function it_returns_nul_for_unknown_name(
        Connection $connection,
        QueryBuilder $qb,
        Statement $statement
    ) {
        $name = 'unknown';

        $connection->createQueryBuilder()->willReturn($qb);

        $this->prepare_find_query_builder($qb);
        $qb->where('p.name = :name')->willReturn($qb);
        $qb->setParameter('name', $name, PDO::PARAM_STR)->willReturn($qb);
        $qb->execute()->willReturn($statement);
        $statement->fetch(PDO::FETCH_ASSOC)->willReturn(false);

        $this->findByName($name)->shouldReturn(null);
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
        $category->setName('fooCat');

        $product = new Product();
        $product->setId('uuid');
        $product->setName('fooProd');
        $product->setQuantity(2);
        $product->setCategory($category);

        $sql = 'UPDATE products
        SET product = ?, category_id = ?, quantity = ?
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
        $category->setId('uuid_category');
        $category->setName('fooCat');

        $product = new Product();
        $product->setId('uuid');
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
        $product->setId('uuid');
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
        $qb->select('p.id, p.name, p.quantity, p.category_id, c.name AS category')->willReturn($qb);
        $qb->from(ProductRepository::TABLENAME, 'p')->willReturn($qb);
        $qb->leftJoin('p', CategoryRepository::TABLENAME, 'c', 'p.category_id = c.id')->willReturn($qb);

        return $qb;
    }

    function get_row_fixture()
    {
        return [
            'id'          => 'uuid',
            'name'        => 'product-name',
            'quantity'    => 666,
            'category_id' => 'uuid_category',
            'category'    => 'category-name',
        ];
    }

    function get_product_fixture()
    {
        return [
            'id'          => 'uuid',
            'name'        => 'product-name',
            'quantity'    => 666,
            'category_id' => 'uuid_category',
            'category'    => [
                'id'   => 'uuid_category',
                'name' => 'category-name',
            ],
        ];
    }
}
