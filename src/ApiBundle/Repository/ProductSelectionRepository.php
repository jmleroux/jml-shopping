<?php

declare(strict_types=1);

namespace Jmleroux\JmlShopping\Api\ApiBundle\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Jmleroux\JmlShopping\Api\ApiBundle\Entity\ProductSelection;
use PDO;

class ProductSelectionRepository
{
    const TABLENAME = 'product_selection';

    /** @var Connection */
    protected $db;

    /** @var CategoryRepository */
    protected $categoryService;

    public function __construct(Connection $db, CategoryRepository $categoryService)
    {
        $this->db = $db;
        $this->categoryService = $categoryService;
    }

    public function findAll(): array
    {
        $qb = $this->getFindQueryBuilder();
        $qb->orderBy('c.name, p.name');

        $stmt = $qb->execute();

        return $stmt->fetchAllAssociative();
    }

    public function getProduct($id): ?array
    {
        $qb = $this->getFindQueryBuilder();
        $qb->where('p.id = :productId')->setParameter('productId', $id, PDO::PARAM_STR);

        $stmt = $qb->execute();
        $row = $stmt->fetchAssociative();

        if (false !== $row) {
            $row['category'] = [
                'id' => $row['category_id'],
                'name' => $row['category'],
            ];

            return $row;
        }

        return null;
    }

    public function remove(string $productId): int
    {
        $sql = sprintf('DELETE FROM %s WHERE id = ?', self::TABLENAME);
        $values = [$productId];

        return $this->db->executeStatement($sql, $values);
    }

    public function create(ProductSelection $product): int
    {
        $sql = sprintf('INSERT INTO %s (id, name, category_id) VALUES (?, ?, ?)', self::TABLENAME);
        $values = [
            $product->getId(),
            $product->getName(),
            $product->getCategoryId(),
        ];

        return $this->db->executeStatement($sql, $values);
    }

    private function getFindQueryBuilder(): QueryBuilder
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('p.id, p.name, p.category_id, c.name AS category')
            ->from(self::TABLENAME, 'p')
            ->leftJoin('p', CategoryRepository::TABLENAME, 'c', 'p.category_id = c.id');

        return $qb;
    }
}
