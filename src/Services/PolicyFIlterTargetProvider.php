<?php

namespace App\Services;

use App\Services\PolicyTargetProviderInterface;

class PolicyFilterTargetProvider implements PolicyTargetProviderInterface
{
    public function getTargets()
    {
        return ['username'=>'test'];
    }
    public function resolves(){
        return true;
    }
}
