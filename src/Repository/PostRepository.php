<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getPostsByBrand(Brand $brand)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','ASC')
            ->where('p.brand = :brand')
            ->setParameter('brand',$brand)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getPostsByModel(Brand $brand, Model $model)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','ASC')
            ->where('p.brand = :brand')
            ->andWhere('p.model = :model')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getPostsByGeneration(Brand $brand, Model $model, Generation $generation)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','ASC')
            ->where('p.brand = :brand')
            ->andWhere('p.model = :model')
            ->andWhere('p.generation = :generation')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getPostsByCarBody(Brand $brand, Model $model, Generation $generation, CarBody $body)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','ASC')
            ->where('p.brand = :brand')
            ->andWhere('p.model = :model')
            ->andWhere('p.generation = :generation')
            ->andWhere('p.carBody = :body')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getPostsByEngine(Brand $brand, Model $model, Generation $generation, CarBody $body, Engine $engine)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','ASC')
            ->where('p.brand = :brand')
            ->andWhere('p.model = :model')
            ->andWhere('p.generation = :generation')
            ->andWhere('p.carBody = :body')
            ->andWhere('p.engine = :engine')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->setParameter('engine',$engine)
            ->getQuery()
            ->getResult()
            ;
    }
}
