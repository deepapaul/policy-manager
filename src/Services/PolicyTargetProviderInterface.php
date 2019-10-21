<?php

namespace App\Services;
use App\Entity\Policy;

interface PolicyTargetProviderInterface
{
    public function getTargets(Policy $policy);
    public function supports(Policy $policy);
}