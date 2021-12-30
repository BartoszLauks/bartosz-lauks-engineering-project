<?php

namespace App\Repository;

use App\Entity\EngineProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EngineProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method EngineProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method EngineProperty[]    findAll()
 * @method EngineProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnginePropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EngineProperty::class);
    }
}
