<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle\Repository;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\CategoryHydrator;

class CategoryRepository
{
    const TABLENAME = 'categories';

    /**
     * @var Connection
     */
    protected $db;

    /**
     * @var CategoryHydrator
     */
    protected $hydrator;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = 'SELECT *
        FROM categories c
        ORDER BY c.name';
        $rows = $this->db->fetchAll($sql);

        $cleaner = function ($row) {
            $row['id'] = (int)$row['id'];

            return $row;
        };

        $rows = array_map($cleaner, $rows);

        return $rows;
    }

    public function findById($categoryId)
    {
        $sql = 'SELECT c.id, c.name
        FROM categories c
        WHERE c.id = ?';

        $values = [$categoryId];
        $row = $this->db->fetchAssoc($sql, $values);

        $category = new Category();
        $category->setId((int)$row['id']);
        $category->setName($row['name']);

        return $category;
    }

    public function create(Category $category)
    {
        $sql = 'INSERT INTO categories (id, name)
        VALUES (null, ?)';
        $values = [
            $category->getName(),
        ];
        $rows = $this->db->executeUpdate($sql, $values);

        return $rows;
    }

    public function update(Category $product)
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

    /**
     * @param int $categoryId
     *
     * @return null
     */
    public function remove($categoryId)
    {
        $sql = 'DELETE FROM categories WHERE id = ?';
        $values = [$categoryId];
        $this->db->executeUpdate($sql, $values);

        return null;
    }

    public function getHydrator()
    {
        if (null == $this->hydrator) {
            $this->hydrator = new CategoryHydrator();
        }

        return $this->hydrator;
    }
}
