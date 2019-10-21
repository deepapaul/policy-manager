<?php

namespace App\Event;

use App\Entity\Policy;
use Symfony\Component\EventDispatcher\Event;

/**
 * @final
 */
class PublishPolicyEvent extends Event
{
    // public const POLICY_PUBLISHING_INITIATED = 'policy.publishing.initiated';

    private $policy;

    // private $data;

    public function __construct(Policy $policy)
    {
        $this->policy = $policy;
        // $this->data = $data;
    }

    public function getPolicy(): Policy
    {
        return $this->policy;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
