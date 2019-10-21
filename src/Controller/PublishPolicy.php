<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Policy;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Event\PublishPolicyEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PublishPolicy extends AbstractController
{
    private $eventDispatcher;

    public function __contruct(EventDispatcherInterface $eventDispatcher){
        $this->eventDispatcher = $eventDispatcher;
    }
    /**
     * @Route(
     *  path="/api/policies/{id}/publish", 
     *  name="publish_policy",
     *  methods={"PATCH"},
     *  defaults={
     *      "_api_respond"=true,
     *      "_api_item_operation_name"="publish_policy",
     *      "_api_swagger_context"={
     *          "tags"={"Policy"},
     *          "summary"="Get targets of a Policy",
     *          "response"={}
     *      }
     *  } 
     * )
     */
    public function __invoke(Policy $data)
    {
        $this->eventDispatcher->dispatch(new PublishPolicyEvent($policy));
        
        return ;
    }
}
