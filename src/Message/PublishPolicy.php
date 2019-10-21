<?php

namespace App\Message;

final class PublishPolicy
{
    private $policyId;

    private $targetUserIds;

    public function __construct(int $policyId, $targetUserIds)
    {
        $this->policyId = $policyId;
        $this->targetUserIds = $targetUserIds;
    }

    public function getPolicyId(): int
    {
        return $this->policyId;
    }

    public function getTargetUserIds(): array
    {
        return $this->targetUserIds;
    }
}
