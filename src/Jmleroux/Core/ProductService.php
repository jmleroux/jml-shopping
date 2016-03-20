<?php

namespace Jmleroux\Core;

use Jmleroux\Core\Entity\Product;
use Jmleroux\Core\Entity\ProductHydrator;
use Doctrine\DBAL\Connection;

class ProductService
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * @var ProductHydrator
     */
    protected $hydrator;

    public function __construct(Connection $db, CategoryService $categoryService)
    {
        $this->db = $db;
        $this->categoryService = $categoryService;
    }

    public function getAll()
    {
        $sql = 'SELECT p.id, p.product, p.quantity,
        c.id AS categoryId, c.label
        FROM products p
        LEFT JOIN categories c ON p.category = c.id
        ORDER BY c.label';

        $products = $this->db->fetchAll($sql);

        return $products;
    }

    public function getProduct($productId)
    {
        $sql = 'SELECT p.id, p.product, p.quantity,
        c.id AS categoryId, c.label
        FROM products p
        LEFT JOIN categories c ON p.category = c.id
        WHERE p.id = ?';

        $values = [$productId];
        $row = $this->db->fetchAssoc($sql, $values);

        $row['category'] = [
            'id' => $row['categoryId'],
            'label' => $row['label']
        ];

        $product = new Product();
        $this->getHydrator()->hydrate($row, $product);

        return $product;
    }

    /**
     * @param int $productId
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
        $sql = 'INSERT INTO products (id, product, category, quantity)
        VALUES (null, ?, ?, ?)';
        $values = [
            $product->getProduct(),
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
            $product->getProduct(),
            $product->getCategory()->getId(),
            $product->getQuantity(),
            $product->getId(),
        ];
        $products = $this->db->executeUpdate($sql, $values);

        return $products;
    }

    public function getHydrator()
    {
        if (null == $this->hydrator) {
            $this->hydrator = new ProductHydrator($this->categoryService);
        }

        return $this->hydrator;
    }
}
