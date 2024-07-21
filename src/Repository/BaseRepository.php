<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository
 */
abstract class BaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    public function searchEntities(array $fields, string $searchTerm): array
    {
        $queryBuilder = $this->createQueryBuilder('e');
        $this->applySearchConditions($queryBuilder, $fields, $searchTerm);

        return $queryBuilder->getQuery()->getResult();
    }

    private function applySearchConditions(QueryBuilder $queryBuilder, array $fields, string $searchTerm): void
    {
        $expr = $queryBuilder->expr()->orX();
        foreach ($fields as $field) {
            $expr->add($queryBuilder->expr()->like('e.' . $field, ':searchTerm'));
        }

        $queryBuilder->where($expr)
            ->setParameter('searchTerm', '%' . $searchTerm . '%');
    }
}
