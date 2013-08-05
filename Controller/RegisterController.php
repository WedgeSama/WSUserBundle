<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use WS\UserBundle\Model\UserInterface;
use WS\UserBundle\WSUserEvents;
use WS\UserBundle\Event\UserEvent;
use JMS\SecurityExtraBundle\Annotation\Secure;

class RegisterController extends Controller {

    /**
     * Display the registration form and validate it.
     * 
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function registerAction(Request $request) {
        $userTools = $this->get('ws_user.user_tools');
        $dispatcher = $this->get('event_dispatcher');
        
        $user = $userTools->createNewUser();
        
        $dispatcher->dispatch(WSUserEvents::REGISTER_START, 
                new UserEvent($user, $request));
        
        $form = $userTools->createRegisterForm($user);
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            
            if ($form->isValid()) {
                $dispatcher->dispatch(WSUserEvents::REGISTER_REQUEST, 
                        new UserEvent($user, $request));
                
                $userTools->saveUser($user);
                
                if ($user->isEnabled())
                    return $this->redirect(
                            $this->generateUrl('WSUserBundle_register_confirm'));
                
                return $this->redirect(
                        $this->generateUrl('WSUserBundle_register_wait'));
            }
        }
        
        return $this->render('WSUserBundle:Register:register.html.twig', 
                array(
                        'user' => $user, 
                        'form' => $form->createView() 
                ));
    }

    /**
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function waitCheckEmailAction() {
        $session = $this->getRequest()
            ->getSession();
        
        if (! $session->has('ws_user.register.wait_email'))
            throw $this->createNotFoundException('Email not found in session.');
        
        return $this->render('WSUserBundle:Register:wait_email.html.twig', 
                array(
                        'email' => $session->get('ws_user.register.wait_email') 
                ));
    }

    /**
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function checkEmailAction(Request $request, $token) {
        $userTools = $this->get('ws_user.user_tools');
        
        $user = $userTools->findByToken($token);
        
        if (! $user)
            throw $this->createNotFoundException('Unable to find User entity.');
        
        $dispatcher = $this->get('event_dispatcher');
        
        $dispatcher->dispatch(WSUserEvents::REGISTER_CONFIRM, 
                new UserEvent($user, $request));
        
        return $this->redirect(
                $this->generateUrl('WSUserBundle_register_confirm'));
    }

    /**
     * Confirm to the user his account is enable.
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function confirmAction() {
        return $this->render('WSUserBundle:Register:confirm.html.twig', 
                array(
                        'user' => $this->getUser() 
                ));
    }

}