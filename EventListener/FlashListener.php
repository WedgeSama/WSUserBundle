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
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\TranslatorInterface;
use WS\UserBundle\Event\SecurityEvent;
use WS\UserBundle\Event\UserEvent;
use WS\UserBundle\WSUserEvents;

/**
 * Add flash messages based on events.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class FlashListener implements EventSubscriberInterface
{
    private $session;

    private $translator;

    private $allowedErrors;

    private static $messages = array(
        WSUserEvents::NEW_ERROR => array('error', 'flash.user.new.error'),
        WSUserEvents::NEW_COMPLETED => array('completed', 'flash.user.new.completed'),
        WSUserEvents::EDIT_ERROR => array('error', 'flash.user.edit.error'),
        WSUserEvents::EDIT_COMPLETED => array('completed', 'flash.user.edit.completed'),
        WSUserEvents::DELETE_ERROR => array('error', 'flash.user.delete.error'),
        WSUserEvents::DELETE_COMPLETED => array('completed', 'flash.user.delete.completed'),
        WSUserEvents::PASSWORD_ERROR => array('error', 'flash.user.password.error'),
        WSUserEvents::PASSWORD_COMPLETED => array('completed', 'flash.user.password.completed'),
    );

    public function __construct(Session $session, TranslatorInterface $translator, $allowedErrors = array())
    {
        $this->session = $session;
        $this->translator = $translator;
        $this->allowedErrors = $allowedErrors;
    }

    public static function getSubscribedEvents()
    {
        return array(
            WSUserEvents::NEW_ERROR => 'message',
            WSUserEvents::NEW_COMPLETED => 'message',
            WSUserEvents::EDIT_ERROR => 'message',
            WSUserEvents::EDIT_COMPLETED => 'message',
            WSUserEvents::DELETE_ERROR => 'message',
            WSUserEvents::DELETE_COMPLETED => 'message',
            WSUserEvents::PASSWORD_ERROR => 'message',
            WSUserEvents::PASSWORD_COMPLETED => 'message',
            WSUserEvents::SECURITY_ERROR_LOGIN => 'securityMessage',
        );
    }

    public function message(UserEvent $event)
    {
        if (!isset(self::$messages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message.');
        }

        $type = self::$messages[$event->getName()][0];
        $msg = $this->trans(self::$messages[$event->getName()][1], 'WSUserBundle', array(
            '%username%' => $event->getUser()->getUsername(),
        ));

        $this->session->getFlashBag()->add($type, $msg);
    }

    private function trans($message, $trans, array $params = array())
    {
        return $this->translator->trans($message, $params, $trans);
    }

    public function securityMessage(SecurityEvent $event)
    {
        $error = $event->getError();
        $errorClass = get_class($error);
        $classPath = explode('\\', $errorClass);
        $error_class = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', end($classPath)));

        if (!isset($this->allowedErrors[$error_class])) {
            throw new \InvalidArgumentException('This error class is not allowed.');
        }

        $vars = array();

        // Get username for specific error class.
        if (is_a($error, 'Symfony\Component\Security\Core\Exception\UsernameNotFoundException')) {
            $vars['%username%'] = $error->getUsername();
        }

        $msg = $this->trans($error->getMessageKey(), 'WSUserBundle', $vars);

        $this->session->getFlashBag()->add('error', $msg);
    }
}