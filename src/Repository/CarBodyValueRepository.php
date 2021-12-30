<?php

namespace App\Repository;

use App\Entity\CarBodyValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarBodyValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarBodyValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarBodyValue[]    findAll()
 * @method CarBodyValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarBodyValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarBodyValue::class);
    }
}
