<?php

namespace App\EventListener\Policy;

use Doctrine\ORM\EntityManagerInterface;
use App\Event\PublishPolicyEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityNotFoundException;
use App\Entity\Policy;
use App\Message\PublishPolicy;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;


final class PublishPolicyListener implements EventSubscriberInterface
{
    private $bus;
    private $entityManager;
    private $providerResolver;
    private $logger;

    public function __construct(
        MessageBusInterface $bus,
        EntityManagerInterface $entityManager,
        PolicyTargetProviderResolver $providerResolver,
        LoggerInterface $logger
    ) {
        $this->bus = $bus;
        $this->entityManager = $entityManager;
        $this->providerResolver = $providerResolver;
        $this->logger = $logger;
    }

    public function intiatePublishingPolicy(PolicyEvent $event): void
    {
        $policy = $event->getPolicy();
        $policy = $this->entityManager->getRepository(Policy::class)->find($message->getPolicyId());
        if (!$policy) {
            throw new EntityNotFoundException('Policy not found.');
        }
        $this->logger->info('Publishing policy : Initiated', [
            'policy' => $policy->getId(),
            'userIds' => $targetUserIds,
        ]);
        $this->bus->dispatch(new PublishPolicy(
            $policy->getId(),
            $targetUserIds
        ));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PublishPolicyEvent::class => 'intiatePublishingPolicy'
        ];
    }
}
