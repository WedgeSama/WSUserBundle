<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Mailer;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\Translator;

/**
 * Mailer for this bundle.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class Mailer
{
    protected $mailer;
    protected $router;
    protected $parameters;
    protected $env;

    /**
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $env
     * @param Translator $trans
     * @param UrlGeneratorInterface $router
     * @param array $parameters
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $env, UrlGeneratorInterface $router, array $parameters)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->parameters = $parameters;
        $this->env = $env;
    }

    /**
     * Send a mail for password change.
     *
     * @param UserInterface $user
     */
    public function sendPasswordMail(UserInterface $user)
    {
        $message = $this->prepareMail($this->parameters['password']['template'], array(
                'username' => $user->getUsername(),
                'password' => $user->getPlainPassword(),
                'user' => $user,
                'url' => $this->router->generate('fos_user_security_login'),
            ))->setFrom($this->parameters['password']['from'])
            ->setTo($user->getEmail());

        $this->mailer->send($message);
    }

    /**
     * Send a mail for new user.
     *
     * @param UserInterface $user
     */
    public function sendNewMail(UserInterface $user)
    {
        $message = $this->prepareMail($this->parameters['new']['template'], array(
                'username' => $user->getUsername(),
                'password' => $user->getPlainPassword(),
                'url' => $this->router->generate('fos_user_security_login'),
                'user' => $user,
            ))->setFrom($this->parameters['new']['from'])
            ->setTo($user->getEmail());

        $this->mailer->send($message);
    }

    /**
     * Send a mail for edited user.
     *
     * @param UserInterface $user
     */
    public function sendEditMail(UserInterface $user)
    {
        $message = $this->prepareMail($this->parameters['edit']['template'], array(
                'username' => $user->getUsername(),
                'user' => $user,
            ))->setFrom($this->parameters['edit']['from'])
            ->setTo($user->getEmail());

        $this->mailer->send($message);
    }

    /**
     * Send a mail for deleted user.
     *
     * @param UserInterface $user
     */
    public function sendDeleteMail(UserInterface $user)
    {
        $message = $this->prepareMail($this->parameters['delete']['template'], array(
                'username' => $user->getUsername(),
                'user' => $user,
            ))->setFrom($this->parameters['delete']['from'])
            ->setTo($user->getEmail());

        $this->mailer->send($message);
    }

    /**
     * Send a mail for disable user.
     *
     * @param UserInterface $user
     */
    public function sendDisableMail(UserInterface $user)
    {
        $message = $this->prepareMail($this->parameters['disable']['template'], array(
                'username' => $user->getUsername(),
                'user' => $user,
            ))->setFrom($this->parameters['disable']['from'])
            ->setTo($user->getEmail());

        $this->mailer->send($message);
    }

    /**
     * Send a mail for blocked user.
     *
     * @param UserInterface $user
     */
    public function sendBlockedMail(UserInterface $user)
    {
        $message = $this->prepareMail($this->parameters['blocked']['template'], array(
                'username' => $user->getUsername(),
                'user' => $user,
            ))->setFrom($this->parameters['blocked']['from'])
            ->setTo($user->getEmail());

        $this->mailer->send($message);
    }

    /**
     * @param $template
     * @param array $vars
     * @param string $trans
     * @return mixed
     */
    protected function prepareMail($template, array $vars = array(), $trans = "WSUserBundle")
    {
        $template = $this->env->loadTemplate($template);

        $bodyHtml = $template->renderBlock('body_html', $vars);
        $bodyText = $template->renderBlock('body_text', $vars);
        $subject = $template->renderBlock('subject', $vars);

        return \Swift_Message::newInstance()->setSubject($subject)
            ->setBody($bodyText, 'text/plain')
            ->addPart($bodyHtml, 'text/html');
    }
}