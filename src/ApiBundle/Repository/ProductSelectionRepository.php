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

        $stmt = $qb->execute();

        return $stmt->fetchAllAssociative();
    }

    public function getProduct($id): ?array
    {
        $qb = $this->getFindQueryBuilder();
        $qb->where('p.id = :productId')->setParameter('productId', $id, PDO::PARAM_STR);

        $stmt = $qb->execute();
        $row = $stmt->fetchAssociative();

        return $row ? $row : null;
    }

    public function findByIds(array $ids): array
    {
        $qb = $this->getFindQueryBuilder();
        $qb->where('p.id IN (:ids)')
            ->setParameter('ids', $ids, Connection::PARAM_STR_ARRAY);

        $stmt = $qb->execute();

        return $stmt->fetchAllAssociative();
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
        $qb->select('p.id, p.name, p.category_id')
            ->from(self::TABLENAME, 'p')
            ->orderBy('p.name');

        return $qb;
    }
}
