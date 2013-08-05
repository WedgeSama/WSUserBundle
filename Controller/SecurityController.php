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

class SecurityController extends Controller {
    
    /**
     * Display the login form.
     * 
     * @Secure(roles="IS_AUTHENTICATED_ANONYMOUSLY")
     */
    public function loginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();
        
        if ($request->attributes->has(
                SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                    SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        if ($error)
            $this->get('ws_tools.flashmsg')
                ->addMsg('error', $error->getMessage());
        
        $csrf = $this->container->has('form.csrf_provider') ? $this->container->get(
                'form.csrf_provider')
            ->generateCsrfToken('authenticate') : null;
        
        return $this->render('WSUserBundle:Security:login.html.twig', 
                array(
                        'last_username' => $session->get(
                                SecurityContext::LAST_USERNAME) ,
                        'csrf' => $csrf,
                        'error' => $error
                ));
    }

}