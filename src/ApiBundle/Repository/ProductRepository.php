<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use PDO;

class ProductRepository
{
    const TABLENAME = 'products';

    /** @var Connection */
    protected $db;

    /** @var CategoryRepository */
    protected $categoryService;

    public function __construct(Connection $db, CategoryRepository $categoryService)
    {
        $this->db = $db;
        $this->categoryService = $categoryService;
    }

    protected function getFindQueryBuilder(): QueryBuilder
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('p.id, p.name, p.quantity, p.category_id, c.name AS category')
            ->from(self::TABLENAME, 'p')
            ->leftJoin('p', CategoryRepository::TABLENAME, 'c', 'p.category_id = c.id');

        return $qb;
    }

    public function getAll()
    {
        $qb = $this->getFindQueryBuilder();
        $qb->orderBy('c.name, p.name');

        $stmt = $qb->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // TODO: find a better way to have integer quantity
        // @see http://php.net/manual/en/pdo.setattribute.php PDO::ATTR_EMULATE_PREPARES
        return array_map([$this, 'cleanRow'], $products);
    }

    public function getProduct($id)
    {
        $qb = $this->getFindQueryBuilder();
        $qb->where('p.id = :productId')->setParameter('productId', $id, PDO::PARAM_STR);

        $stmt = $qb->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (false !== $row) {
            $row = $this->cleanRow($row);
            $row['category'] = [
                'id' => $row['category_id'],
                'name' => $row['category'],
            ];

            return $row;
        }

        return null;
    }

    /**
     * @param int $name
     *
     * @return array|null
     */
    public function findByName($name)
    {
        $qb = $this->getFindQueryBuilder();
        $qb->where('p.name = :name')->setParameter('name', $name, PDO::PARAM_STR);

        $stmt = $qb->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (false !== $row) {
            $row['category'] = [
                'id' => $row['category_id'],
                'name' => $row['category'],
            ];

            return $row;
        }

        return null;
    }

    /**
     * @param int $productId
     *
     * @return null
     */
    public function remove($productId): int
    {
        $sql = 'DELETE FROM products WHERE id = ?';
        $values = [$productId];

        return $this->db->executeUpdate($sql, $values);
    }

    public function removeAll(): void
    {
        $sql = 'DELETE FROM products';
        $this->db->executeQuery($sql);
    }

    public function create(Product $product)
    {
        $sql = 'INSERT INTO products (id, name, category_id, quantity)
        VALUES (?, ?, ?, ?)';
        $values = [
            $product->getId(),
            $product->getName(),
            $product->getCategory() ? $product->getCategory()->getId() : null,
            $product->getQuantity(),
        ];
        $products = $this->db->executeUpdate($sql, $values);

        return $products;
    }

    public function update(Product $product)
    {
        $sql = 'UPDATE products
        SET product = ?, category_id = ?, quantity = ?
        WHERE id = ?';
        $values = [
            $product->getName(),
            $product->getCategory()->getId(),
            $product->getQuantity(),
            $product->getId(),
        ];
        $products = $this->db->executeUpdate($sql, $values);

        return $products;
    }

    private function cleanRow(array $row): array
    {
        $row['quantity'] = (int)$row['quantity'];

        return $row;
    }
}
