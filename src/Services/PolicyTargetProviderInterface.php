<?php

namespace App\Services;

interface PolicyTargetProviderInterface
{
    public function getTargets();
    public function resolves();
}