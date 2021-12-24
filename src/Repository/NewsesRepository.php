<?php

namespace App\Repository;

use App\Entity\Newses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Newses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Newses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Newses[]    findAll()
 * @method Newses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Newses::class);
    }

    public function getNewses()
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.createdAt',"DESC")
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }
}
