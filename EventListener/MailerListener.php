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
use WS\UserBundle\Mailer\Mailer;
use WS\UserBundle\WSUserEvents;

/**
 * Send mail based on events and bundle configuration.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class MailerListener implements EventSubscriberInterface
{
    protected $mailer;
    protected $parameters;

    private static $types = array(
        WSUserEvents::NEW_COMPLETED => 'new',
        WSUserEvents::EDIT_COMPLETED => 'edit',
        WSUserEvents::DELETE_COMPLETED => 'delete',
        WSUserEvents::PASSWORD_COMPLETED => 'password',
    );

    public function __construct(Mailer $mailer, array $parameters = array())
    {
        $this->mailer = $mailer;
        $this->parameters = $parameters;
    }

    public static function getSubscribedEvents()
    {
        return array(
            WSUserEvents::NEW_COMPLETED => 'sendMail',
            WSUserEvents::EDIT_COMPLETED => 'sendMail',
            WSUserEvents::DELETE_COMPLETED => 'sendMail',
            WSUserEvents::PASSWORD_COMPLETED => 'sendMail',
        );
    }

    public function sendMail(UserEvent $event)
    {
        if (!isset(self::$types[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known mailer function.');
        }

        $type = self::$types[$event->getName()];

        if (array_key_exists($type, $this->parameters)) {
            $method = sprintf('send%sMail', ucfirst($type));
            $this->mailer->$method($event->getUser());
        }
    }
}