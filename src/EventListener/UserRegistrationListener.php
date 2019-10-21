<?php

namespace App\EventListener\Policy;

use Doctrine\ORM\EntityManagerInterface;
use App\Event\UserRegistrationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Log\LoggerInterface;
use App\Entity\User;
use App\Entity\PolicyUsers;

final class UserRegistrationListener implements EventSubscriberInterface
{
    private $entityManager;
    private $logger;

    public function __construct(
        EntityManagerInterface $entityManager,
        PolicyTargetProviderResolver $providerResolver,
        LoggerInterface $logger
    ) {
        $this->bus = $bus;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function distributePoliciesForUser(UserRegistrationEvent $event): void
    {
        $user = $event->getUser();
        $policyIds = $this->entityManager->getRepository(Policy::class)->filterPolicies($jobId, $departmentId);
        $this->entityManager->getRepository(PolicyUsers::class)->distributePoliciesForAUser($user, $policyIds);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserRegistrationEvent::USER_REGISTERED => ['distributePoliciesForUser',100]
        ];
    }
}
