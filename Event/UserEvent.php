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
use WS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;

class UserEvent extends Event {

    private $request;

    private $user;

    public function __construct(UserInterface $user, Request $request) {
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * @return UserInterface
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->request;
    }

}