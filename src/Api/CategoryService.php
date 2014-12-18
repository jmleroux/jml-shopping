<?php

namespace Api;

use Api\Entity\Category;
use Api\Entity\CategoryHydrator;
use Doctrine\DBAL\Connection;
use Silex;

class CategoryService
{
    /**
     * @var \Silex\Application
     */
    protected $app;

    /**
     * @var CategoryHydrator
     */
    protected $hydrator;

    public function __construct(Silex\Application $app)
    {
        $this->app = $app;
    }

    public function getAll()
    {
        $sql  = "SELECT *
        FROM categories c
        ORDER BY c.label";
        $rows = $this->getDb()->fetchAll($sql);

        $cleaner = function ($row) {
            $row['id'] = (int) $row['id'];
            return $row;
        };

        $rows = array_map($cleaner, $rows);

        return $rows;
    }

    public function getCategory($categoryId)
    {
        $sql = "SELECT c.id AS categoryId, c.label
        FROM categories c
        WHERE c.id = ?";

        $values = array($categoryId);
        $row    = $this->getDb()->fetchAssoc($sql, $values);

        $category = new Category();
        $category->setId($row['categoryId']);
        $category->setLabel($row['label']);

        return $category;
    }

    public function create(Category $category)
    {
        $sql    = "INSERT INTO categories (id, label)
        VALUES (null, ?)";
        $values = array(
            $category->getLabel(),
        );
        $rows   = $this->getDb()->executeUpdate($sql, $values);

        return $rows;
    }

    public function update(Category $product)
    {
        $sql    = "UPDATE categories
        SET label = ?
        WHERE id = ?";
        $values = array(
            $product->getLabel(),
            $product->getId(),
        );
        $rows   = $this->getDb()->executeUpdate($sql, $values);

        return $rows;
    }

    /**
     * @param int $categoryId
     * @return null
     */
    public function remove($categoryId)
    {
        $sql    = "DELETE FROM categories WHERE id = ?";
        $values = array($categoryId);
        $this->getDb()->executeUpdate($sql, $values);

        return null;
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
            $this->hydrator = new CategoryHydrator($this->app);
        }

        return $this->hydrator;
    }
}
