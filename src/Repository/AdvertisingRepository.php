<?php

namespace App\Repository;

use App\Entity\Advertising;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @method Advertising|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advertising|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advertising[]    findAll()
 * @method Advertising[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertisingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advertising::class);
    }

    public function getActiveAdvertising(\DateTime $date)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.dueDate > :date')
            ->andWhere('a.file LIKE :png')
            ->orWhere('a.file LIKE :jpg')
            ->setParameter('date', $date)
            ->setParameter('png',"%".".jpg")
            ->setParameter('jpg',"%".".png")
            ->orderBy('a.dueDate', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
