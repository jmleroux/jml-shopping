<?php

namespace Jmleroux\Api;

use Jmleroux\Api\Entity\Product;
use Jmleroux\Api\Entity\ProductHydrator;
use Doctrine\DBAL\Connection;
use Silex;

class ProductService
{
    /**
     * @var \Silex\Application
     */
    protected $app;

    /**
     * @var ProductHydrator
     */
    protected $hydrator;

    public function __construct(Silex\Application $app)
    {
        $this->app = $app;
    }

    public function getAll()
    {
        $sql = 'SELECT p.id, p.product, p.quantity,
        c.id AS categoryId, c.label
        FROM products p
        LEFT JOIN categories c ON p.category = c.id
        ORDER BY c.label';

        $products = $this->getDb()->fetchAll($sql);

        return $products;
    }

    public function getProduct($productId)
    {
        $sql = 'SELECT p.id, p.product, p.quantity,
        c.id AS categoryId, c.label
        FROM products p
        LEFT JOIN categories c ON p.category = c.id
        WHERE p.id = ?';

        $values = array($productId);
        $row    = $this->getDb()->fetchAssoc($sql, $values);

        $row['category'] = [
            'id'    => $row['categoryId'],
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
        $sql    = 'DELETE FROM products WHERE id = ?';
        $values = array($productId);
        $this->getDb()->executeUpdate($sql, $values);

        return null;
    }

    public function removeAll()
    {
        $sql = 'DELETE FROM products';
        $this->getDb()->executeQuery($sql);

        return null;
    }

    public function create(Product $product)
    {
        $sql      = 'INSERT INTO products (id, product, category, quantity)
        VALUES (null, ?, ?, ?)';
        $values   = array(
            $product->getProduct(),
            $product->getCategory() ? $product->getCategory()->getId() : null,
            $product->getQuantity(),
        );
        $products = $this->getDb()->executeUpdate($sql, $values);

        return $products;
    }

    public function update(Product $product)
    {
        $sql      = 'UPDATE products
        SET product = ?, category = ?, quantity = ?
        WHERE id = ?';
        $values   = array(
            $product->getProduct(),
            $product->getCategory()->getId(),
            $product->getQuantity(),
            $product->getId(),
        );
        $products = $this->getDb()->executeUpdate($sql, $values);

        return $products;
    }

    /**
     * @return Connection
     */
    protected function getDb()
    {
        return $this->app['db'];
    }

    public function getHydrator()
    {
        if (null == $this->hydrator) {
            $this->hydrator = new ProductHydrator($this->app);
        }

        return $this->hydrator;
    }
}
