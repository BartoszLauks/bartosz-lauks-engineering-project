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
use PhpParser\Node\Scalar\String_;
use Symfony\Component\Security\Core\Security;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    private Security $security;

    public function __construct(ManagerRegistry $registry,Security $security)
    {
        parent::__construct($registry, Post::class);
        $this->security = $security;
    }

    public function searchPosts(string $str)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->where('LOWER(p.title) LIKE :str')
            ->orWhere('LOWER(p.content) LIKE :str')
            ->setParameter('str','%'.strtolower($str).'%')
            ->getQuery()
            ->getResult()
            ;
    }


    public function getPostsUser()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->where('p.user = :user')
            ->setParameter('user',$this->security->getUser())
            ->getQuery()
            ->getResult()
            ;
    }

    public function getPosts()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getPostsByBrand(Brand $brand)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->where('p.brand = :brand')
            ->setParameter('brand',$brand)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getPostsByModel(Brand $brand, Model $model)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
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
            ->orderBy('p.createdAt','DESC')
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
            ->orderBy('p.createdAt','DESC')
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
            ->orderBy('p.createdAt','DESC')
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
