<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Policy;
use App\Services\PolicyTargetProviderResolver;

class PolicyTargets extends AbstractController
{
    /**
     * @var PolicyTargetProviderResolver
     * 
     */
    private $providerResolver;

    public function __construct(PolicyTargetProviderResolver $providerResolver){
        $this->providerResolver = $providerResolver;
    }
    public function __invoke(Policy $policy)
    {
        $provider = $this->providerResolver->resolve($policy);
        return $provider->getTargets($policy);
    }
}
