<?php

namespace App\Repository;

use App\Entity\EngineValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EngineValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method EngineValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method EngineValue[]    findAll()
 * @method EngineValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EngineValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EngineValue::class);
    }
}
