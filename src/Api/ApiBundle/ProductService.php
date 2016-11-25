<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Product;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\ProductHydrator;
use PDO;

class ProductService
{
    const TABLENAME = 'products';
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
        $qb = $this->db->createQueryBuilder();
        $qb->select('p.id, p.product, p.quantity, c.id AS categoryId, c.label')
            ->from(self::TABLENAME, 'p')
            ->leftJoin('p', CategoryService::TABLENAME, 'c', 'p.category = c.id')
            ->orderBy('c.label');

        $stmt = $qb->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    public function getProduct($id)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('p.id, p.product, p.quantity, c.id AS categoryId, c.label')
            ->from(self::TABLENAME, 'p')
            ->leftJoin('p', CategoryService::TABLENAME, 'c', 'p.category = c.id')
            ->where('p.id = :productId')
            ->setParameter('productId', $id, PDO::PARAM_INT);

        $stmt = $qb->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $row['category'] = [
            'id'    => $row['categoryId'],
            'label' => $row['label'],
        ];

        $product = new Product();
        $this->getHydrator()->hydrate($row, $product);

        return $product;
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
