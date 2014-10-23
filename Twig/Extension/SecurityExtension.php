<?php

namespace WS\UserBundle\Twig\Extension;

use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityExtension extends \Twig_Extension
{
    protected $csrfProvider;
    protected $session;

    public function __construct(CsrfProviderInterface $csrfProvider = null, SessionInterface $session = null)
    {
        $this->csrfProvider = $csrfProvider;
        $this->session = $session;
    }

    public function getFunctions()
    {
        return array (
            'csrf_token' => new \Twig_Function_Method($this, 'csrfToken', array (
                    'is_safe' => array (
                        'html'
                    )
                )),
            'last_username' => new \Twig_Function_Method($this, 'lastUsername', array (
                    'is_safe' => array (
                        'html'
                    )
                )),
        );
    }

    public function csrfToken()
    {
        return $this->csrfProvider
            ? $this->csrfProvider->generateCsrfToken('authenticate')
            : null;
    }

    public function lastUsername()
    {
        return (null === $this->session)
            ? ''
            : $this->session->get(SecurityContext::LAST_USERNAME);
    }

    public function getName()
    {
        return 'ws_security_extension';
    }
}