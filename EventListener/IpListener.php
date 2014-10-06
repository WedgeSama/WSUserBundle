<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Model\UserManagerInterface;
use WS\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class IpListener implements EventSubscriberInterface
{
    protected $um;

    public function __construct(UserManagerInterface $um)
    {
        $this->um = $um;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'onImplicitLogin',
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
        );
    }

    public function onImplicitLogin(UserEvent $event)
    {
        $this->updateIp($event->getUser());
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->updateIp($event->getAuthenticationToken()->getUser());
    }

    private function updateIp($user)
    {
        if ($user instanceof User) {
            $user->setIp($_SERVER['REMOTE_ADDR']);
            $this->um->updateUser($user);
        }
    }
}
