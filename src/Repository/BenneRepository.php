<?php

namespace App\Repository;

use App\Entity\Benne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Benne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Benne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Benne[]    findAll()
 * @method Benne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BenneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Benne::class);
    }

    // /**
    //  * @return Benne[] Returns an array of Benne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Benne
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
