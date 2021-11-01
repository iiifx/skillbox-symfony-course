<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function findAllWithSearchQuery(?string $search, bool $showDeleted = false): Query
    {
        $qb = $this->queryBuilder();

        if ($search) {
            $qb->andWhere('t.name LIKE :search OR t.slug LIKE :search OR a.title LIKE :search')
                ->setParameter('search', "%$search%");
        }

        if ($showDeleted) {
            $this->getEntityManager()->getFilters()->disable('softdeleteable');
        }

        return $qb->orderBy('t.createdAt', 'DESC')->getQuery();
    }

    private function queryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.articles', 'a')
            ->addSelect('a');
    }
}
