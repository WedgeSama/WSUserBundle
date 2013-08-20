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
use Symfony\Component\Security\Core\SecurityContext;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

class PasswordController extends Controller {

    /**
     * Display the form to reset password.
     *
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function askAction(Request $request) {
        $userTools = $this->get('ws_user.user_tools');
        
        $form = $userTools->createPasswordAskForm();
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            
            $user = $userTools->validPasswordAskForm($form);
            
            if ($user) {
                if ($userTools->tokenIsExpire($user)) {
                    $userTools->initUserToken($user);
                    $userTools->saveUser($user);
                    
                    $mailer = $this->get('ws_tools.mailer');
                    
                    $param = array(
                            'user' => $user, 
                            'url' => $this->generateUrl(
                                    'WSUserBundle_password_reset', 
                                    array(
                                            'token' => $user->getToken() 
                                    ), true) 
                    );
                    
                    $msg = $mailer->prepareMail(
                            'WSUserBundle:Password:ask.email.twig', 
                            'ws_user_bundle.password.ask.subject', $param);
                    
                    $msg->setFrom(
                            $this->container->getParameter(
                                    'ws_user.password_reset.sender_email'), 
                            $this->get('translator')
                                ->trans('ws_user_bundle.password.ask.name', 
                                    array(), 'emails'));
                    
                    $msg->setTo($user->getEmail());
                    $mailer->send($msg);
                    
                    $session = $request->getSession();
                    
                    $session->set('ws_user.password.send_email', 
                            $user->getEmail());
                    
                    return $this->redirect(
                            $this->generateUrl('WSUserBundle_password_send'));
                }
                
                $this->get('ws_tools.flashmsg')
                    ->addMsg('error', 'ws_user_bundle.password.ask.already');
            }
        }
        
        return $this->render('WSUserBundle:Password:ask.html.twig', 
                array(
                        'form' => $form->createView() 
                ));
    }

    /**
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function sendEmailAction() {
        $session = $this->getRequest()
            ->getSession();
        
        if (! $session->has('ws_user.password.send_email'))
            throw $this->createNotFoundException('Email not found in session.');
        
        return $this->render('WSUserBundle:Password:send_email.html.twig');
    }

    /**
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function resetAction(Request $request, $token) {
        $userTools = $this->get('ws_user.user_tools');
        
        $user = $userTools->findByToken($token, true);
        
        if (! $user)
            throw $this->createNotFoundException('Unable to find User entity.');
        
        if ($userTools->tokenIsExpire($user))
            return $this->render('WSUserBundle:Password:expired.html.twig');
        
        $form = $userTools->createPasswordResetForm($user);
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            
            if ($form->isValid()) {
                $userTools->deleteToken($user);
                $userTools->saveUser($user);
                $userTools->loginUser($user);
                
                $session = $request->getSession();
                $session->set('ws_user.password.reset', true);
                
                return $this->redirect(
                        $this->generateUrl('WSUserBundle_password_confirm'));
            }
        }
        
        return $this->render('WSUserBundle:Password:reset.html.twig', 
                array(
                        'form' => $form->createView() 
                ));
    }

    /**
     * Confirm to the user his password was reset.
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function confirmAction() {
        $session = $this->getRequest()
            ->getSession();
        
        if (! $session->has('ws_user.password.reset'))
            throw $this->createNotFoundException(
                    'Password not found in session.');
        
        $session->remove('ws_user.password.reset');
        
        return $this->render('WSUserBundle:Password:confirm.html.twig', 
                array(
                        'user' => $this->getUser() 
                ));
    }

}