<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }

    public function getOneModelByGeneration(Generation $generation, CarBody $body, Engine $engine)
    {
        return $this->createQueryBuilder('m')
            ->join('m.generations','g','m.id = g.model')
            ->join('g.carBodies','cb','g.id = cb.generation')
            ->join('cb.engines','e','cb.id = e.body')
            ->where('g = :generation')
            ->andWhere('cb = :body')
            ->andWhere('e = :engine')
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->setParameter('engine',$engine)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getModelWithBrandRelation(Brand $brand)
    {
        return $this->createQueryBuilder('m')
            ->join('m.brand','b','m.id = b.model')
            ->where('b = :brand')
            ->setParameter('brand',$brand)
            ->getQuery()
            ->getResult()
            ;
    }
}
