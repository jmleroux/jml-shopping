<?php

namespace Jmleroux\Core;

use Jmleroux\Core\Entity\Category;
use Jmleroux\Core\Entity\CategoryHydrator;
use Doctrine\DBAL\Connection;

class CategoryService
{
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
        $sql  = 'SELECT *
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

    public function getCategory($categoryId)
    {
        $sql = 'SELECT c.id AS categoryId, c.label
        FROM categories c
        WHERE c.id = ?';

        $values = array($categoryId);
        $row    = $this->db->fetchAssoc($sql, $values);

        $category = new Category();
        $category->setId($row['categoryId']);
        $category->setLabel($row['label']);

        return $category;
    }

    public function create(Category $category)
    {
        $sql    = 'INSERT INTO categories (id, label)
        VALUES (null, ?)';
        $values = array(
            $category->getLabel(),
        );
        $rows   = $this->db->executeUpdate($sql, $values);

        return $rows;
    }

    public function update(Category $product)
    {
        $sql    = 'UPDATE categories
        SET label = ?
        WHERE id = ?';
        $values = array(
            $product->getLabel(),
            $product->getId(),
        );
        $rows   = $this->db->executeUpdate($sql, $values);

        return $rows;
    }

    /**
     * @param int $categoryId
     * @return null
     */
    public function remove($categoryId)
    {
        $sql    = 'DELETE FROM categories WHERE id = ?';
        $values = array($categoryId);
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
