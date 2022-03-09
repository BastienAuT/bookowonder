<?php

namespace App\Repository;

use App\Entity\Pinnedpage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pinnedpage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pinnedpage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pinnedpage[]    findAll()
 * @method Pinnedpage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PinnedpageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pinnedpage::class);
    }


    public function findMostPinned()
    {

        return $this->createQueryBuilder('p')
            ->groupBy('p.book')
            ->orderBy('count(p.id)', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    
    // /**
    //  * @return Pinnedpage[] Returns an array of Pinnedpage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pinnedpage
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
