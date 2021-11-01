<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @return Comment[]
     */
    public function findAllWithSearch(?string $search, bool $showDeleted = false): array
    {
        return $this->findAllWithSearchQuery($search, $showDeleted)->getResult();
    }

    public function findAllWithSearchQuery(?string $search, bool $showDeleted = false): Query
    {
        $qb = $this->queryBuilder();

        if ($search) {
            $qb->andWhere('c.content LIKE :search OR c.authorName LIKE :search OR a.title LIKE :search')
                ->setParameter('search', "%$search%");
        }

        if ($showDeleted) {
            $this->getEntityManager()->getFilters()->disable('softdeleteable');
        }

        return $qb->orderBy('c.createdAt', 'DESC')->getQuery();
    }

    /**
     * @return Comment[]
     */
    public function findLatestPublished(int $count): array
    {
        $qb = $this->queryBuilder();

        return $qb->orderBy('c.createdAt', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    private function queryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.article', 'a')
            ->addSelect('a');
    }
}
