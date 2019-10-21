<?php

namespace App\Services;

use App\Services\PolicyTargetProviderInterface;
use App\Entity\Policy;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class PolicyFilterTargetProvider implements PolicyTargetProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    public function getTargets(Policy $policy)
    {
        return $this->em->getRepository(User::class)->getPolicyTargetUsers($policy->getPolicyFilters());
    }
    public function supports(Policy $policy){
        if(true !== $policy->getIsToAllUsers() && $policy->getPolicyFilters()->count()>0){
            return true;
        }
    }
}
