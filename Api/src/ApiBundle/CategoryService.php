<?php

namespace Jmleroux\JmlShopping\Api\ApiBundle;

use Doctrine\DBAL\Connection;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\Category;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\CategoryHydrator;

class CategoryService
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
        ORDER BY c.label';
        $rows = $this->db->fetchAll($sql);

        $cleaner = function ($row) {
            $row['id'] = (int) $row['id'];

            return $row;
        };

        $rows = array_map($cleaner, $rows);

        return $rows;
    }

    public function findById($categoryId)
    {
        $sql = 'SELECT c.id, c.label
        FROM categories c
        WHERE c.id = ?';

        $values = [$categoryId];
        $row = $this->db->fetchAssoc($sql, $values);

        $category = new Category();
        $category->setId((int) $row['id']);
        $category->setLabel($row['label']);

        return $category;
    }

    public function create(Category $category)
    {
        $sql = 'INSERT INTO categories (id, label)
        VALUES (null, ?)';
        $values = [
            $category->getLabel(),
        ];
        $rows = $this->db->executeUpdate($sql, $values);

        return $rows;
    }

    public function update(Category $product)
    {
        $sql = 'UPDATE categories
        SET label = ?
        WHERE id = ?';
        $values = [
            $product->getLabel(),
            $product->getId(),
        ];
        $rows = $this->db->executeUpdate($sql, $values);

        return $rows;
    }

    /**
     * @param int $categoryId
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
