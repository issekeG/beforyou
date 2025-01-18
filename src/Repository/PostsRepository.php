<?php

namespace App\Repository;

use App\Entity\Posts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Posts>
 */
class PostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posts::class);
    }

        /**
         * @return Posts[] Returns an array of Posts objects
         */
    public function findBySector($value): array
    {
            return $this->createQueryBuilder('p')
                ->andWhere('p.sector = :val')
                ->setParameter('val', $value)
                ->orderBy('p.publishedAt', 'DESC')
                ->setMaxResults(3)
                ->getQuery()
                ->getResult()
            ;
    }
    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.publishedAt', 'DESC') // Trier par la date de publication (descendant)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findTop3OrderedByDate(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.publishedAt', 'DESC') // Trier par la date de publication (descendant)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Posts
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
