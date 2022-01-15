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
 * @method Brand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brand[]    findAll()
 * @method Brand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    public function getOneBrandByModel(Model $model,Generation $generation, CarBody $body, Engine $engine)
    {
        return $this->createQueryBuilder('b')
            ->join('b.models','m','b.id = m.brand')
            ->join('m.generations','g','m.id = g.model')
            ->join('g.carBodies','cb','g.id = cb.generation')
            ->join('cb.engines','e','cb.id = e.body')
            ->where('m = :model')
            ->andWhere('g = :generation')
            ->andWhere('cb = :body')
            ->andWhere('e = :engine')
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->setParameter('engine',$engine)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }
}
