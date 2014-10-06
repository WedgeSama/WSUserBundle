<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Security event.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class SecurityEvent extends Event
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var AuthenticationException
     */
    private $error;

    public function __construct(AuthenticationException $error, Request $request)
    {
        $this->error = $error;
        $this->request = $request;
    }

    /**
     * @return AuthenticationException
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
