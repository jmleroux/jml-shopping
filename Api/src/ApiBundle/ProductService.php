<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use PDO;

class ProductService
{
    const TABLENAME = 'products';

    /** @var Connection */
    protected $db;

    /** @var CategoryService */
    protected $categoryService;

    public function __construct(Connection $db, CategoryService $categoryService)
    {
        $this->db = $db;
        $this->categoryService = $categoryService;
    }

    public function getAll()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('p.id, p.name, p.quantity, c.id AS categoryId, c.label AS category')
            ->from(self::TABLENAME, 'p')
            ->leftJoin('p', CategoryService::TABLENAME, 'c', 'p.category_id = c.id')
            ->orderBy('c.label');

        $stmt = $qb->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    public function getProduct($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('p.id, p.name, p.quantity, c.id AS categoryId, c.label')
            ->from(self::TABLENAME, 'p')
            ->leftJoin('p', CategoryService::TABLENAME, 'c', 'p.category_id = c.id')
            ->where('p.id = :productId')
            ->setParameter('productId', $id, PDO::PARAM_INT);

        $stmt = $qb->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (false !== $row) {
            $row['category'] = [
                'id'    => $row['categoryId'],
                'label' => $row['label'],
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
        $qb = $this->db->createQueryBuilder();
        $qb->select('p.id, p.name, p.quantity, c.id AS categoryId, c.label')
            ->from(self::TABLENAME, 'p')
            ->leftJoin('p', CategoryService::TABLENAME, 'c', 'p.category_id = c.id')
            ->where('p.name = :name')
            ->setParameter('name', $name, PDO::PARAM_STR);

        $stmt = $qb->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (false !== $row) {
            $row['category'] = [
                'id'    => $row['categoryId'],
                'label' => $row['label'],
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
    public function remove($productId)
    {
        $sql = 'DELETE FROM products WHERE id = ?';
        $values = [$productId];
        $this->db->executeUpdate($sql, $values);

        return null;
    }

    public function removeAll()
    {
        $sql = 'DELETE FROM products';
        $this->db->executeQuery($sql);

        return null;
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
        SET product = ?, category = ?, quantity = ?
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
}
