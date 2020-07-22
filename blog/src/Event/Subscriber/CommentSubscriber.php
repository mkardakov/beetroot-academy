<?php
declare(strict_types=1);


namespace App\Event\Subscriber;


use App\Event\CommentEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class CommentSubscriber implements EventSubscriberInterface
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            CommentEvent::COMMENT_ADDED => ['log'],
        ];
    }

    public function log(CommentEvent $event)
    {
        $this->logger->info($event->getComment()->getBody(), [
            'user' => $event->getUser()
        ]);
    }
}