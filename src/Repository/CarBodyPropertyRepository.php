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

}
