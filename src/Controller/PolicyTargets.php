<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Policy;

class PolicyTargets extends AbstractController
{
    /**
     * @var PolicyTargetProviderResolver
     * 
     */
    private $providerResolver;

    public function __construct(PolicyTargetProviderResolver $providerResolver){

    }
    public function __invoke(Policy $policy)
    {
        $provider = $providerResolver->resolve($policy);

    }
}
