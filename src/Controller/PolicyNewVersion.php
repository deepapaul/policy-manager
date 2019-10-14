<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Policy;
use Doctrine\ORM\EntityManagerInterface;

class PolicyNewVersion extends AbstractController
{
    /**
     * @Route(
     *  path="/api/policy/{id}/version", 
     *  name="policy_new_version",
     *  methods={"POST"},
     *  defaults={
     *      "_api_respond"=true,
     *      "_api_resource_class"=Policy::class,
     *      "_api_item_operation_name"="policy_new_version",
     *      "_api_swagger_context"={
     *          "tags"={"Policy"},
     *          "summary"="Get targets of a Policy",
     *          "response"={}
     *      }
     *  } 
     * )
     */
    public function __invoke(Policy $policy, EntityManagerInterface $em)
    {
        $newVersion = clone $policy;
        $em->persist($newVersion);
        $em->flush();
        return $newVersion;
    }
}
