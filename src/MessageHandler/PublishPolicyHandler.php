<?php

namespace App\MessageHandler;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use App\Entity\Policy;
use App\Message\PublishPolicy;
use App\Services\PolicyTargetProviderResolver;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Repository\PolicyUsers;

class PublishPolicyHandler implements MessageHandlerInterface
{
    private $entityManager;
    private $providerResolver;
    private $logger;

    public function __construct(
        EntityManagerInterface $entityManager,
        PolicyTargetProviderResolver $providerResolver,
        LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->providerResolver = $providerResolver;
        $this->logger = $logger;
    }

    public function __invoke(PublishPolicy $message): void
    {
        $policy = $this->entityManager->getRepository(Policy::class)->find($message->getPolicyId());
        if (!$policy) {
            throw new EntityNotFoundException('Policy not found.');
        }
        $provider = $this->providerResolver->resolve($policy);
        $targetUserIds = $provider->getTargets($policy);

        try {
            $this->em->getRepository(PolicyUsers::class)->distributeToUsersByPolicy($policy, $targetUserIds);
            $policy->setPublishedAt(new \DateTime());
            $entityManager->flush();
            $this->logger->info('Policy Published', [
                'policy' => $policy->getId(),
                'userIds' => $targetUserIds,
            ]);
        } catch (\Exception $e){
            $this->logger->info('Publishing Policy: Failed', [
                'policy' => $policy->getId(),
                'userIds' => $targetUserIds,
                'exception' => $e->getMessage()
            ]);
        }
    }
}
