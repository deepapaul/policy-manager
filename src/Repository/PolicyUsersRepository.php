<?php

namespace App\Repository;

use App\Entity\PolicyUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PolicyUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method PolicyUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method PolicyUsers[]    findAll()
 * @method PolicyUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PolicyUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PolicyUsers::class);
    }

    // /**
    //  * @return PolicyUsers[] Returns an array of PolicyUsers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PolicyUsers
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
