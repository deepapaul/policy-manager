<?php

namespace App\Services;
use App\Services\PolicyTargetProviderInterface;

class PolicyAllTargetsProvider implements PolicyTargetProviderInterface
{
    public function getTargets()
    {
        return 'test --- PolicyAllTargetsProvider';
    }
    public function resolves(){
        return false;
    }
}
