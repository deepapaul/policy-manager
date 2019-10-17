<?php

namespace App\Services;
use App\Entity\Policy;

class PolicyTargetProviderResolver
{
    /**
     * @var TargetsIdentifiersProviderInterface[]
     */
    private $providers;

    public function __construct(PolicyTargetProviderInterface ...$providers){
        $this->providers = $providers;

    }
    public function resolve(Policy $policy): PolicyTargetProviderInterface
    {
        foreach($providers as $provider){
            if($provider->resolves($policy)){
                return $provider;
            }
        }
    }   
    
}
