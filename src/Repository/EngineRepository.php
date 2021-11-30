<?php

namespace App\Repository;

use App\Entity\Engine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Engine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Engine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Engine[]    findAll()
 * @method Engine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EngineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Engine::class);
    }


    public function findByCarBody($body = 4): QueryBuilder
    {
        return $this->createQueryBuilder('e')
            ->join('e.body','c','c.id = e.id')
            ->where('c.id = :val')
            ->setParameter('val',$body)
        ;
    }

    public function testQB()
    {
        return $this->createQueryBuilder('e')
            ->join()
            ->getQuery()
            ->getResult()
            ;

    }
    // /**
    //  * @return Engine[] Returns an array of Engine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Engine
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
