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

    public function findBySlug(string $slug, bool $publishedOnly = true): ?Article
    {
        $qb = $this->queryBuilder();

        if ($publishedOnly) {
            $qb = $this->publishedOnly($qb);
        }

        return $qb
            ->andWhere('a.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Article[]
     */
    public function findLatestPublished(): array
    {
        $qb = $this->publishedOnly();
        $qb = $this->orderLatest($qb);

        return $qb
            //->setMaxResults(10)
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

    protected function publishedOnly(QueryBuilder $qb = null): QueryBuilder
    {
        $qb ??= $this->queryBuilder();

        return $qb->andWhere('a.publishedAt IS NOT NULL');
    }

    protected function orderLatest(QueryBuilder $qb = null): QueryBuilder
    {
        $qb ??= $this->queryBuilder();

        return $qb->orderBy('a.publishedAt', 'DESC');
    }

    protected function queryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.comments', 'c')
            ->addSelect('c');
    }
}
