<?php

namespace App\Repository;

use App\Entity\Article;
use DateTime;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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

    public function findAllWithSearchQuery(?string $search, bool $showDeleted = false): Query
    {
        $qb = $this->queryBuilder()
            ->innerJoin('a.author', 'au')
            ->addSelect('au');

        if ($search) {
            $qb
                ->andWhere('a.title LIKE :search OR a.body LIKE :search OR au.firstName LIKE :search')
                ->setParameter('search', "%$search%");
        }

        if ($showDeleted) {
            $this->getEntityManager()->getFilters()->disable('softdeleteable');
        }

        return $qb->orderBy('a.createdAt', 'DESC')->getQuery();
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

    /**
     * @return Article[]
     */
    public function findAllPublishedLastWeek(): array
    {
        return $this->publishedOnly($this->orderLatest())
            ->andWhere('a.publishedAt >= :lastWeek')
            ->setParameter('lastWeek', new DateTime('-1 week'))
            ->getQuery()
            ->getResult();
    }

    protected function publishedOnly(QueryBuilder $qb = null): QueryBuilder
    {
        $qb ??= $this->queryBuilder();

        return $qb->andWhere('a.publishedAt IS NOT NULL');
    }

    public function orderLatest(QueryBuilder $qb = null): QueryBuilder
    {
        $qb ??= $this->queryBuilder();

        return $qb->orderBy('a.publishedAt', 'DESC');
    }

    public function queryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.comments', 'c')
            ->addSelect('c')
            ->innerJoin('a.tags', 't')
            ->addSelect('t');
    }

    public function countCreated(DateTimeInterface $dateFrom, DateTimeInterface $dateTo): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->andWhere('a.createdAt >= :dateFrom', 'a.createdAt <= :dateTo')
            ->setParameters([
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ])
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countPublished(DateTimeInterface $dateFrom, DateTimeInterface $dateTo): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->andWhere('a.publishedAt >= :dateFrom', 'a.publishedAt <= :dateTo')
            ->setParameters([
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ])
            ->getQuery()
            ->getSingleScalarResult();
    }
}
