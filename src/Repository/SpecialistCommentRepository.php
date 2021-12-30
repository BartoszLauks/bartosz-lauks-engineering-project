<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Entity\SpecialistComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SpecialistComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialistComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialistComment[]    findAll()
 * @method SpecialistComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialistCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialistComment::class);
    }

    public function getSpecialistComment()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getSpecialistCommentByBrand(Brand $brand)
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->where('s.brand = :brand')
            ->setParameter('brand',$brand)
            ->getQuery()
            ->getResult();
    }

    public function getSpecialistCommentByModel(Brand $brand, Model $model)
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->where('s.brand = :brand')
            ->andWhere('s.model = :model')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->getQuery()
            ->getResult();
    }

    public function getSpecialistCommentByGeneration(Brand $brand, Model $model, Generation $generation)
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->where('s.brand = :brand')
            ->andWhere('s.model = :model')
            ->andWhere('s.generation = :generation')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->getQuery()
            ->getResult();
    }

    public function getSpecialistCommentByCarBody(Brand $brand, Model $model, Generation $generation, CarBody $body)
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->where('s.brand = :brand')
            ->andWhere('s.model = :model')
            ->andWhere('s.generation = :generation')
            ->andWhere('s.body = :body')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->getQuery()
            ->getResult();
    }

    public function getSpecialistCommentByEngine(Brand $brand, Model $model, Generation $generation, CarBody $body, Engine $engine)
    {
        return $this->createQueryBuilder('s')
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
            ->getQuery()
            ->getResult();
    }
}
