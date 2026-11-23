<?php

namespace App\Repository;

use App\Entity\Coaster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Coaster>
 */
class CoasterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coaster::class);
    }

    public function findFiltered(?int $parkId = null, ?int $categoryId = null, int $page = 1, int $limit = 5): Paginator
    {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.park', 'p')
            ->addSelect('p')
            ->leftJoin('c.categories', 'cat')
            ->addSelect('cat')
            ->orderBy('c.name', 'ASC');

        if ($parkId) {
            $qb->andWhere('p.id = :parkId')
            ->setParameter('parkId', $parkId);
        }

        if ($categoryId) {
            $qb->andWhere('cat.id = :categoryId')
            ->setParameter('categoryId', $categoryId);
        }

        $query = $qb->getQuery()
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($query);
    }

//    /**
//     * @return Coaster[] Returns an array of Coaster objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Coaster
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
