<?php

namespace App\Repository;

use App\Entity\CarBodyProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarBodyProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarBodyProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarBodyProperty[]    findAll()
 * @method CarBodyProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarBodyPropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarBodyProperty::class);
    }

    // /**
    //  * @return CarBodyProperty[] Returns an array of CarBodyProperty objects
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
    public function findOneBySomeField($value): ?CarBodyProperty
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
