<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Generation;
use App\Entity\Model;
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

    public function getCarBodyWithGenerationModelBrandRelation(Brand $brand, Model $model, Generation $generation)
    {
        return $this->createQueryBuilder('cb')
            ->join('cb.generation','g','cb.id = g.carBodies')
            ->join('g.model','m','g.id = m.generation')
            ->join('m.brand','b','m.brand = b.id')
            ->where('b = :brand')
            ->andWhere('m = :model')
            ->andWhere('g = :generation')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->getQuery()
            ->getResult()
            ;
    }
}
