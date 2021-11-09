<?php

namespace App\Repository;

use App\Entity\CarBody;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarBody|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarBody|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarBody[]    findAll()
 * @method CarBody[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarBodyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarBody::class);
    }

    // /**
    //  * @return CarBody[] Returns an array of CarBody objects
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
    public function findOneBySomeField($value): ?CarBody
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
