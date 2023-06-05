<?php

namespace App\Repository;

use App\Entity\LastBennesUpdate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LastBennesUpdate|null find($id, $lockMode = null, $lockVersion = null)
 * @method LastBennesUpdate|null findOneBy(array $criteria, array $orderBy = null)
 * @method LastBennesUpdate[]    findAll()
 * @method LastBennesUpdate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LastBennesUpdateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LastBennesUpdate::class);
    }

    // /**
    //  * @return LastBennesUpdate[] Returns an array of LastBennesUpdate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LastBennesUpdate
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
