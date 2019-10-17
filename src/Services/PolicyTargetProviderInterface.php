<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Policy;

class PolicyTargets extends AbstractController
{
    /**
     * @Route(
     *  path="/api/policy/{id}/targets",
     *  name="get_policy_targets",
     *  methods={"GET"},
     *  defaults={
     *      "_api_resource_class"=Policy::Class,
     *      "_api_item_operation_name"="get_policy_users",
     *      "_api_swagger_context"={
     *          "tags"={"Policy"},
     *          "summary"="Get targets of a Policy",
     *          "response"={}
     *      }  
     *  }
     * )
     * 
     */
    public function __invoke(Policy $policy)
    {
        return $policy->getPolicyUsers();
        
    }
}
