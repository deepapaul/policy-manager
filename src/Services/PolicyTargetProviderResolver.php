<?php

namespace App\Services;
use App\Entity\Policy;
use App\Services\PolicyTargetProviderInterface;

class PolicyTargetProviderResolver
{
    private $providers;

    public function __construct(iterable $providers){
        $this->providers = $providers;

    }
    public function resolve(Policy $policy): PolicyTargetProviderInterface
    {
        foreach($this->providers as $provider){
            if($provider->supports($policy)){
                return $provider;
            }
        }
    }   
    
}
