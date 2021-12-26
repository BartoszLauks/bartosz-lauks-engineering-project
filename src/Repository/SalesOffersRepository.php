<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Entity\SalesOffers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SalesOffers|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesOffers|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesOffers[]    findAll()
 * @method SalesOffers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesOffersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalesOffers::class);
    }

    public function getOffersByBrand(Brand $brand)
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','ASC')
            ->where('o.brand = :brand')
            ->setParameter('brand',$brand)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getOffersByModel(Brand $brand, Model $model)
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','ASC')
            ->where('o.brand = :brand')
            ->andWhere('o.model = :model')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getOffersByGeneration(Brand $brand, Model $model, Generation $generation)
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','ASC')
            ->where('o.brand = :brand')
            ->andWhere('o.model = :model')
            ->andWhere('o.generation = :generation')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getOffersByCarBody(Brand $brand, Model $model, Generation $generation, CarBody $body)
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','ASC')
            ->where('o.brand = :brand')
            ->andWhere('o.model = :model')
            ->andWhere('o.generation = :generation')
            ->andWhere('o.carBody = :body')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getOffersByEngine(Brand $brand, Model $model, Generation $generation, CarBody $body, Engine $engine)
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','ASC')
            ->where('o.brand = :brand')
            ->andWhere('o.model = :model')
            ->andWhere('o.generation = :generation')
            ->andWhere('o.carBody = :body')
            ->andWhere('o.engine = :engine')
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
