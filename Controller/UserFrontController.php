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

/**
 * User front controller.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class UserFrontController extends Controller
{
    /**
     * List all User entities with pagination system.
     */
    public function indexAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $page = $this->get('request')->query->get('page', 1);

        $query = $userManager->queryUsers();

        $paginator = $this->get('knp_paginator');
        $users = $paginator->paginate($query, $page);

        return $this->render('WSUserBundle:UserFront:index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Finds and displays a User entity.
     */
    public function showAction($username)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $this->render('WSUserBundle:UserFront:show.html.twig', array(
            'user' => $user,
        ));
    }
}