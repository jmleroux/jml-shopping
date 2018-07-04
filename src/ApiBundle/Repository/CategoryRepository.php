<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Repository;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;

class CategoryRepository
{
    const TABLENAME = 'categories';

    /**
     * @var Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $sql = 'SELECT *
        FROM categories c
        ORDER BY c.name';
        $rows = $this->db->fetchAll($sql);

        return $rows;
    }

    public function findById(string $categoryId): Category
    {
        $sql = 'SELECT c.id, c.name
        FROM categories c
        WHERE c.id = ?';

        $values = [$categoryId];
        $row = $this->db->fetchAssoc($sql, $values);

        $category = new Category();
        $category->setId((string)$row['id']);
        $category->setName($row['name']);

        return $category;
    }

    public function create(Category $category): int
    {
        $sql = 'INSERT INTO categories (id, name)
        VALUES (?, ?)';
        $values = [
            $category->getId(),
            $category->getName(),
        ];
        $rows = $this->db->executeUpdate($sql, $values);

        return $rows;
    }

    public function update(Category $product): int
    {
        $sql = 'UPDATE categories
        SET name = ?
        WHERE id = ?';
        $values = [
            $product->getName(),
            $product->getId(),
        ];
        $rows = $this->db->executeUpdate($sql, $values);

        return $rows;
    }

    public function remove(string $categoryId): int
    {
        $sql = 'DELETE FROM categories WHERE id = ?';
        $values = [$categoryId];
        return $this->db->executeUpdate($sql, $values);
    }
}
