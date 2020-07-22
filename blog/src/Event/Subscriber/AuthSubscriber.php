<?php
declare(strict_types=1);


namespace App\Event\Subscriber;


use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class AuthSubscriber
 * @package App\Event\Subscriber
 */
class AuthSubscriber implements EventSubscriberInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * AuthSubscriber constructor.
     * @param LoggerInterface $authLogger
     */
    public function __construct(LoggerInterface $authLogger)
    {
        $this->logger = $authLogger;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => ['logAuth', 500],
            AuthenticationEvents::AUTHENTICATION_SUCCESS => ['logAuth', 500],
            AuthenticationEvents::AUTHENTICATION_FAILURE => ['logAuth', 500]
        ];
    }

    /**
     * @param Event $event
     */
    public function logAuth(Event $event)
    {
        $level = 'info';
        switch (true) {
            case $event instanceof LogoutEvent:
                $message = "User {$event->getToken()->getUser()->getName()} logged out";
                break;
            case $event instanceof AuthenticationSuccessEvent:
                $userName = '';
                if ($event->getAuthenticationToken() && $event->getAuthenticationToken()->getUser() instanceof UserInterface) {
                    $userName = $event->getAuthenticationToken()->getUser()->getName();
                }
                $message = "User {$userName} logged successfully";
                break;
            case $event instanceof AuthenticationFailureEvent:
                $message = "User loggin FAILED";
                $level = 'warning';
                break;
        }
        $this->logger->log($level, $message);
    }
}