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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use WS\UserBundle\WSUserEvents;
use WS\UserBundle\Event\SecurityEvent;

class SecurityController extends BaseController
{
    /**
     * Same as \FOS\UserBundle\Controller\SecurityController::loginAction(), just add event dispatcher.
     */
    public function loginAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();
        $dispatcher = $this->container->get('event_dispatcher');

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // ADD EVENT DISPATCHER
            $dispatcher->dispatch(WSUserEvents::SECURITY_ERROR_LOGIN, new SecurityEvent($error, $request));
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->has('form.csrf_provider')
            ? $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'csrf_token' => $csrfToken,
        ));
    }
}
