<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
    public const PAGINATOR_PER_PAGE = 4;

    private Security $security;

    public function __construct(ManagerRegistry $registry,Security $security)
    {
        parent::__construct($registry, Post::class);
        $this->security = $security;
    }

    public function searchPosts(string $str,int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->where('LOWER(p.title) LIKE :str')
            ->orWhere('LOWER(p.content) LIKE :str')
            ->setParameter('str','%'.strtolower($str).'%')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }


    public function getPostsUser(int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->where('p.user = :user')
            ->setParameter('user',$this->security->getUser())
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getPosts(int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getPostsByBrand(Brand $brand, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->where('p.brand = :brand')
            ->setParameter('brand',$brand)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
    public function getPostsByModel(Brand $brand, Model $model, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->where('p.brand = :brand')
            ->andWhere('p.model = :model')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
    public function getPostsByGeneration(Brand $brand, Model $model, Generation $generation, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->where('p.brand = :brand')
            ->andWhere('p.model = :model')
            ->andWhere('p.generation = :generation')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
    public function getPostsByCarBody(Brand $brand, Model $model, Generation $generation, CarBody $body, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt','DESC')
            ->where('p.brand = :brand')
            ->andWhere('p.model = :model')
            ->andWhere('p.generation = :generation')
            ->andWhere('p.carBody = :body')
            ->setParameter('brand',$brand)
            ->setParameter('model',$model)
            ->setParameter('generation',$generation)
            ->setParameter('body',$body)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
    public function getPostsByEngine(Brand $brand, Model $model, Generation $generation, CarBody $body, Engine $engine, int $offset) : Paginator
    {
        $query = $this->createQueryBuilder('p')
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
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
}
