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
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class IpListener implements EventSubscriberInterface {

    protected $userManager;

    public function __construct(UserManagerInterface $userManager) {
        $this->userManager = $userManager;
    }

    public static function getSubscribedEvents() {
        return array(
                FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'onImplicitLogin', 
                SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin' 
        );
    }

    public function onImplicitLogin(UserEvent $event) {
        $user = $event->getUser();
        
        $user->setIp($_SERVER['REMOTE_ADDR']);
        $this->userManager->updateUser($user);
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) {
        $user = $event->getAuthenticationToken()
            ->getUser();
        
        if ($user instanceof UserInterface) {
            $user->setIp($_SERVER['REMOTE_ADDR']);
            $this->userManager->updateUser($user);
        }
    }

}
