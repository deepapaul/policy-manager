<?php

namespace App\Repository;

use App\Entity\PolicyUsers;
use App\Entity\Policy;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Repository\UserRepository;
use App\Repository\PolicyRepository;

/**
 * @method PolicyUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method PolicyUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method PolicyUsers[]    findAll()
 * @method PolicyUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PolicyUsersRepository extends ServiceEntityRepository
{
    private $userRepository;

    private $policyRepository;

    public function __construct(ManagerRegistry $registry, UserRepository $userRepository, PolicyRepository $policyRepository)
    {
        parent::__construct($registry, PolicyUsers::class);
        $this->userRepository = $userRepository;
        $this->policyRepository = $policyRepository;
    }

    public function distributeToUsersByPolicy(Policy $policy, array $userIds){
        $em = $this->getEntityManager();
        foreach($userIds as $userId){
            $user = $this->userRepository->findOneById($userId);
            if(!$user){
                continue;
            }
            $this->setPolicyUser($policy, $user);   
        }
        $this->getEntityManager()->flush();
    }
    
    public function distributePoliciesForAUser(User $user, $policyIds){
        $em = $this->getEntityManager();
        foreach($policyIds as $policyId){
            $policy = $this->policyRepository->findOneById($policyId);
            if(!$user){
                continue;
            }
            $this->setPolicyUser($policy, $user);
        }
        $this->getEntityManager()->flush();
    }

    private function setPolicyUser($policy, $user){
        $policyUser = new PolicyUsers();
        $policyUser->setPolicy($policy);
        $policyUser->setUser($user);
        $this->getEntityManager()->persist($policyUser);
    }
}
