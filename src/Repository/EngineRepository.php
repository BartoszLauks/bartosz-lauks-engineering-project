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
 * @method Engine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Engine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Engine[]    findAll()
 * @method Engine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EngineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Engine::class);
    }

    public function getEngineWithCarBodyGenerationBrandModelRelation(Brand $brand, Model $model, Generation $generation,CarBody $body)
    {
        return $this->createQueryBuilder('e')
            ->join('e.body','cb','e.id = cb.engines')
            ->join('cb.generation','g','cb.id = g.carBodies')
            ->join('g.model','m','g.id = m.generation')
            ->join('m.brand','b','m.brand = b.id')
            ->where('b = :brand')
            ->andWhere('m = :model')
            ->andWhere('g = :generation')
            ->andWhere('cb = :body')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->getQuery()
            ->getResult()
            ;
    }

    public function checkCarExist(Brand $brand, Model $model, Generation $generation,CarBody $body,Engine $engine)
    {
        return $this->createQueryBuilder('e')
            //->select('e, cb, g, m, b')
            ->join('e.body','cb','e.id = cb.engines')
            ->join('cb.generation','g','cb.id = g.carBodies')
            ->join('g.model','m','g.id = m.generation')
            ->join('m.brand','b','m.brand = b.id')
            ->where('b = :brand')
            ->andWhere('m = :model')
            ->andWhere('g = :generation')
            ->andWhere('cb = :body')
            ->andWhere('e = :engine')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->setParameter('engine',$engine)
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return Engine[] Returns an array of Engine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Engine
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
