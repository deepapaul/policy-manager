<?php

namespace App\Repository;

use App\Entity\Policy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Policy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Policy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Policy[]    findAll()
 * @method Policy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PolicyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Policy::class);
    }

    public function filterPolicies($jobId, $departmentId)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('p.id')
            ->leftJoin('p.PolicyFilter pf')
            ->where('p.isToAllUsers = :isToAllUsers')
            
            ->orWhere('pf.department = :departmentId AND pf.job IS NULL')
            ->orWhere('pf.department IS NULL AND pf.job = :jobId')
            ->orWhere('pf.department = :departmentId AND pf.job = :jobId')
            ->setParameters(['isToAllUsers' => true, 'departmentId' => $departmentId, 'jobId' => $jobId]);
        return array_column($queryBuilder->getQuery->getArrayResult(), 'id');

    }
}
