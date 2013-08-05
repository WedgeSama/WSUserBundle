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
use WS\UserBundle\WSUserEvents;
use WS\UserBundle\Event\UserEvent;
use WS\UserBundle\Tools\UserTools;
use WS\ToolsBundle\Services\Mailer;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\Translator;

class RegisterListener implements EventSubscriberInterface {

    /**
     * @var boolean
     */
    private $check_email;

    /**
     * @var UserTools
     */
    private $tools;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var string
     */
    private $email;

    /**
     * @var Translator
     */
    private $trans;

    public function __construct(UserTools $tools, Mailer $mailer, Router $router, 
        Translator $trans, $check_email, $email) {
        $this->check_email = $check_email;
        $this->tools = $tools;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->email = $email;
        $this->trans = $trans;
    }

    public static function getSubscribedEvents() {
        return array(
                WSUserEvents::REGISTER_REQUEST => 'request' ,
                WSUserEvents::REGISTER_CONFIRM => 'confirm'
        );
    }

    /**
     * Call by WSUserEvents::REGISTER_REQUEST event
     * 
     * @param UserEvent $event
     */
    public function request(UserEvent $event) {
        $user = $event->getUser();
        
        if ($this->check_email) {
            $user->setEnabled(false);
            $this->tools->initUserToken($user, false);
            $session = $event->getRequest()
                ->getSession();
            
            $session->set('ws_user.register.wait_email', $user->getEmail());
            
            $param = array(
                    'user' => $user, 
                    'url' => $this->router->generate(
                            'WSUserBundle_security_login', array(), true) 
            );
            
            $msg = $this->mailer->prepareMail(
                    'WSUserBundle:Register:confirm.email.twig', 
                    'ws_user_bundle.register.subject', $param);
            
            $msg->setFrom($this->email, 
                    $this->trans->trans('ws_user_bundle.register.name', array(), 
                            'emails'));
            $msg->setTo($user->getEmail());
            
            $this->mailer->send($msg);
        } else {
            $user->setEnabled(true);
            $this->tools->loginUser($user);
        }
    }

    /**
     * Call by WSUserEvents::REGISTER_CONFIRM event
     * 
     * @param UserEvent $event
     */
    public function confirm(UserEvent $event) {
        $user = $event->getUser();
        $session = $event->getRequest()
            ->getSession();
        
        if ($session->has('ws_user.register.wait_email'))
            $session->remove('ws_user.register.wait_email');
        
        $this->tools->deleteToken($user);
        $user->setEnabled(true);
        
        $this->tools->saveUser($user);
        $this->tools->loginUser($user);
    }

}