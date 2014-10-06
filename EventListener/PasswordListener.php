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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WS\UserBundle\Event\UserEvent;
use WS\UserBundle\Util\PasswordGeneratorInterface;
use WS\UserBundle\WSUserEvents;

/**
 * Set new password for user based on events.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class PasswordListener implements EventSubscriberInterface
{

    protected $generator;

    public function __construct(PasswordGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            WSUserEvents::NEW_SUCCESS => array('generatePassword', -120),
            WSUserEvents::PASSWORD_SUCCESS => array('generatePassword', -120),
        );
    }

    public function generatePassword(UserEvent $event)
    {
        $user = $event->getUser();
        $password = $this->generator->generatePassword();

        $user->setPlainPassword($password);
    }

}
