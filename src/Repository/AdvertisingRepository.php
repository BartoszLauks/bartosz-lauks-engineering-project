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

    public function getActiveAdvertising()
    {
        $date = new \DateTime();

        return $this->createQueryBuilder('a')
            ->where('a.dueDate > :date')
            ->andWhere('a.file LIKE :jpg OR a.file LIKE :png OR a.file LIKE :PNG OR a.file LIKE :JPG OR a.file LIKE :gif OR a.file LIKE :GIF')
            ->setParameter('date', $date)
            ->setParameter('png',"%".".png")
            ->setParameter('jpg',"%".".jpg")
            ->setParameter('JPG',"%".".JPG")
            ->setParameter('PNG',"%".".PNG")
            ->setParameter('gif',"%".".gif")
            ->setParameter('GIF',"%".".GIF")
            ->orderBy('a.dueDate', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
