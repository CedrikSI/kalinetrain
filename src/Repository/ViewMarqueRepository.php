<?php

namespace App\Repository;

use App\Entity\ViewMarque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ViewMarque>
 *
 * @method ViewMarque|null find($id, $lockMode = null, $lockVersion = null)
 * @method ViewMarque|null findOneBy(array $criteria, array $orderBy = null)
 * @method ViewMarque[]    findAll()
 * @method ViewMarque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViewMarqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ViewMarque::class);
    }

//    /**
//     * @return ViewMarque[] Returns an array of ViewMarque objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ViewMarque
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
