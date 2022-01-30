<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Entity\SalesOffers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method SalesOffers|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesOffers|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesOffers[]    findAll()
 * @method SalesOffers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesOffersRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 4;

    private $security;

    public function __construct(ManagerRegistry $registry,Security $security)
    {
        parent::__construct($registry, SalesOffers::class);
        $this->security = $security;
    }

    public function getUserOffers(int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','DESC')
            ->where('o.user = :user')
            ->setParameter('user',$this->security->getUser())
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getOffers(int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getOffersByBrand(Brand $brand, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','DESC')
            ->where('o.brand = :brand')
            ->setParameter('brand',$brand)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
    public function getOffersByModel(Brand $brand, Model $model, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','DESC')
            ->where('o.brand = :brand')
            ->andWhere('o.model = :model')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
    public function getOffersByGeneration(Brand $brand, Model $model, Generation $generation, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','DESC')
            ->where('o.brand = :brand')
            ->andWhere('o.model = :model')
            ->andWhere('o.generation = :generation')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
    public function getOffersByCarBody(Brand $brand, Model $model, Generation $generation, CarBody $body, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','DESC')
            ->where('o.brand = :brand')
            ->andWhere('o.model = :model')
            ->andWhere('o.generation = :generation')
            ->andWhere('o.carBody = :body')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
    public function getOffersByEngine(Brand $brand, Model $model, Generation $generation, CarBody $body, Engine $engine, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.createdAt','DESC')
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
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
}
