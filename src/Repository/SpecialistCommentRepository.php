<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Entity\SpecialistComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SpecialistComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialistComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialistComment[]    findAll()
 * @method SpecialistComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialistCommentRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 4;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialistComment::class);
    }

    public function getSpecialistComment(int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getSpecialistCommentByBrand(Brand $brand, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->where('s.brand = :brand')
            ->setParameter('brand',$brand)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getSpecialistCommentByModel(Brand $brand, Model $model, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->where('s.brand = :brand')
            ->andWhere('s.model = :model')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getSpecialistCommentByGeneration(Brand $brand, Model $model, Generation $generation, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->where('s.brand = :brand')
            ->andWhere('s.model = :model')
            ->andWhere('s.generation = :generation')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getSpecialistCommentByCarBody(Brand $brand, Model $model, Generation $generation, CarBody $body, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->where('s.brand = :brand')
            ->andWhere('s.model = :model')
            ->andWhere('s.generation = :generation')
            ->andWhere('s.body = :body')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getSpecialistCommentByEngine(Brand $brand, Model $model, Generation $generation, CarBody $body, Engine $engine, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->where('s.brand = :brand')
            ->andWhere('s.model = :model')
            ->andWhere('s.generation = :generation')
            ->andWhere('s.body = :body')
            ->andWhere('s.engine = :engine')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->setParameter('engine', $engine)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
}
