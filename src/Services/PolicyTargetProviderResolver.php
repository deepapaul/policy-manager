<?php

namespace App\Services;
use App\Entity\Policy;
use App\Services\PolicyTargetProviderInterface;

class PolicyTargetProviderResolver
{
    private $providers;

    public function __construct(PolicyTargetProviderInterface ...$providers){
        $this->providers = $providers;

    }
    public function resolve(Policy $policy): PolicyTargetProviderInterface
    {
        dump($this->providers);exit;
        foreach($this->providers as $provider){
            if($provider->resolves($policy)){
                return $provider;
            }
        }
    }   
    
}
