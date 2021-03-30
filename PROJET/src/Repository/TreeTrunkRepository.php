<?php

namespace App\Repository;

use App\Entity\TreeTrunk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TreeTrunk|null find($id, $lockMode = null, $lockVersion = null)
 * @method TreeTrunk|null findOneBy(array $criteria, array $orderBy = null)
 * @method TreeTrunk[]    findAll()
 * @method TreeTrunk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TreeTrunkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TreeTrunk::class);
    }

    // /**
    //  * @return TreeTrunk[] Returns an array of TreeTrunk objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TreeTrunk
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
