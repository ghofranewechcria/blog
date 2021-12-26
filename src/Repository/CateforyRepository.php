<?php

namespace App\Repository;

use App\Entity\Catefory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Catefory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Catefory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Catefory[]    findAll()
 * @method Catefory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CateforyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catefory::class);
    }

    // /**
    //  * @return Catefory[] Returns an array of Catefory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Catefory
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
