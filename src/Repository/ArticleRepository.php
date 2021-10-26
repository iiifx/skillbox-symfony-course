<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[]
     */
    public function findLatestPublished(): array
    {
        $builder = $this->publishedOnly();
        $builder = $this->orderLatest($builder);

        return $builder
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[]
     */
    public function findPublished(): array
    {
        return $this->publishedOnly()
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[]
     */
    public function findLatest(): array
    {
        return $this->orderLatest()
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    protected function publishedOnly(QueryBuilder $builder = null): QueryBuilder
    {
        $builder ??= $this->queryBuilder();

        return $builder->andWhere('a.publishedAt IS NOT NULL');
    }

    protected function orderLatest(QueryBuilder $builder = null): QueryBuilder
    {
        $builder ??= $this->queryBuilder();

        return $builder->orderBy('a.publishedAt', 'DESC');
    }

    protected function queryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('a');
    }
}
