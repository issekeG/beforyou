<?php

namespace App\Repository;

use App\Entity\Realisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Realisation>
 */
class RealisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Realisation::class);
    }
    public function findAllOrderedByDate():Array{
        return $this->createQueryBuilder('r')
            ->orderBy('r.deliveryAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

        /**
         * @return Realisation[] Returns an array of Realisation objects
         */
        public function findByActivity($value): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.activity = :val')
                ->setParameter('val', $value)
                ->orderBy('r.id', 'ASC')
                ->setMaxResults(50)
                ->getQuery()
                ->getResult()
            ;
        }

        public function findOneBySlug($slug): ?Realisation
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.slug = :val')
                ->setParameter('val', $slug)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
