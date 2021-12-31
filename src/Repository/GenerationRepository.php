<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\Generation;
use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Generation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Generation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Generation[]    findAll()
 * @method Generation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenerationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Generation::class);
    }

    public function getNewGenerationsYearAgo()
    {
        $date = date('Y')-1;

        return $this->createQueryBuilder('g')
            ->where('g.producedFrom = :year')
            ->setParameter('year',$date)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getNewGenerations()
    {
        $date = date('Y');

        return $this->createQueryBuilder('g')
            ->where('g.producedFrom = :year')
            ->setParameter('year',$date)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getGenerationWithBrandModelRelation(Brand $brand, Model $model)
    {
        return $this->createQueryBuilder('g')
            ->join('g.model','m','g.id = m.generation')
            ->join('m.brand','b','m.brand = b.id')
            ->where('b = :brand')
            ->andWhere('m = :model')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->getQuery()
            ->getResult()
            ;
    }
}
