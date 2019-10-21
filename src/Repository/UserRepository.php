<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getPolicyTargetUsers(Collection $policyFilters = null):array
    {

        $queryBuilder = $this->createQueryBuilder('u');
        if($policyFilters){
            $filterConditions = [];
            foreach($policyFilters as $policyFilter){
                if($policyFilter->getJob() && $policyFilter->getDepartment()){
                    $filterConditions[] = $queryBuilder->expr()->andX(
                                            $queryBuilder->expr()->eq('u.job', $policyFilter->getJob()->getId()),
                                            $queryBuilder->expr()->eq('u.department', $policyFilter->getDepartment()->getId())
                                        );
                }elseif($policyFilter->getJob()){
                    $filterConditions[] = $queryBuilder->expr()->eq('u.job', $policyFilter->getJob()->getId());
                }elseif($policyFilter->getDepartment()){
                    $filterConditions[] = $queryBuilder->expr()->eq('u.department', $policyFilter->getDepartment()->getId());
                }
            }
            $queryBuilder->where($queryBuilder->expr()->orX(...$filterConditions));
        }
        return array_column($queryBuilder->getQuery()->getArrayResult(), 'id');
    }
}
