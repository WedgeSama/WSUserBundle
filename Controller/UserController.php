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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WS\UserBundle\Event\UserEvent;
use WS\UserBundle\WSUserEvents;

/**
 * User controller. Make an admin interface for users.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class UserController extends Controller
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

        $formFactory = $this->get('ws_user.form.user_factory');

        // Create a delete form skeleton, you have to use it on client side with some js.
        $deleteForm = $formFactory->createDeleteForm();

        return $this->render('WSUserBundle:User:index.html.twig', array(
            'users' => $users,
            'deleteForm' => $deleteForm->createView(),
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

        $formFactory = $this->get('ws_user.form.user_factory');
        $deleteForm = $formFactory->createDeleteForm($user->getUsername());
        $passwordForm = $formFactory->createPasswordForm($user->getUsername());

        return $this->render('WSUserBundle:User:show.html.twig', array(
            'user' => $user,
            'deleteForm' => $deleteForm->createView(),
            'passwordForm' => $passwordForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new User entity.
     */
    public function newAction(Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->createUser();
        $dispatcher->dispatch(WSUserEvents::NEW_INITIALIZE, new UserEvent($user, $request));

        $formFactory = $this->get('ws_user.form.user_factory');
        $form = $formFactory->createNewForm($user);

        if ($request->getMethod() == "POST") {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $dispatcher->dispatch(WSUserEvents::NEW_SUCCESS, new UserEvent($user, $request));

                $userManager->updateUser($user);

                $dispatcher->dispatch(WSUserEvents::NEW_COMPLETED, new UserEvent($user, $request));

                return $this->redirect($this->generateUrl('ws_user_user_show', array(
                    'username' => $user->getUsername()
                )));
            }

            $dispatcher->dispatch(WSUserEvents::NEW_ERROR, new UserEvent($user, $request));
        }

        return $this->render('WSUserBundle:User:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     */
    public function editAction(Request $request, $username)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $dispatcher = $this->container->get('event_dispatcher');
        $user = $userManager->findUserByUsername($username);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $dispatcher->dispatch(WSUserEvents::EDIT_INITIALIZE, new UserEvent($user, $request));

        $formFactory = $this->get('ws_user.form.user_factory');
        $form = $formFactory->createEditForm($user);

        if ($request->getMethod() == "POST" || $request->getMethod() == "PUT") {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $dispatcher->dispatch(WSUserEvents::EDIT_SUCCESS, new UserEvent($user, $request));

                $userManager->updateUser($user);

                $dispatcher->dispatch(WSUserEvents::EDIT_COMPLETED, new UserEvent($user, $request));

                return $this->redirect($this->generateUrl('ws_user_user_edit', array(
                    'username' => $username,
                )));
            }

            $dispatcher->dispatch(WSUserEvents::EDIT_ERROR, new UserEvent($user, $request));
        }

        $deleteForm = $formFactory->createDeleteForm($user->getUsername());
        $passwordForm = $formFactory->createPasswordForm($user->getUsername());

        return $this->render('WSUserBundle:User:edit.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'deleteForm' => $deleteForm->createView(),
            'passwordForm' => $passwordForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     */
    public function deleteAction(Request $request, $username)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $dispatcher = $this->container->get('event_dispatcher');
        $user = $userManager->findUserByUsername($username);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $dispatcher->dispatch(WSUserEvents::DELETE_INITIALIZE, new UserEvent($user, $request));

        $formFactory = $this->get('ws_user.form.user_factory');
        $form = $formFactory->createDeleteForm($username);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $dispatcher->dispatch(WSUserEvents::DELETE_SUCCESS, new UserEvent($user, $request));

            $userManager->deleteUser($user);

            $dispatcher->dispatch(WSUserEvents::DELETE_COMPLETED, new UserEvent($user, $request));
        } else {
            $dispatcher->dispatch(WSUserEvents::DELETE_ERROR, new UserEvent($user, $request));
        }

        return $this->redirect($this->generateUrl('ws_user_user_list'));
    }

    /**
     * Update a User password.
     *
     * @param Request $request
     * @param $username
     */
    public function passwordAction(Request $request, $username)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $dispatcher = $this->container->get('event_dispatcher');
        $user = $userManager->findUserByUsername($username);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $dispatcher->dispatch(WSUserEvents::PASSWORD_INITIALIZE, new UserEvent($user, $request));

        $formFactory = $this->get('ws_user.form.user_factory');
        $form = $formFactory->createPasswordForm($username);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $dispatcher->dispatch(WSUserEvents::PASSWORD_SUCCESS, new UserEvent($user, $request));

            $userManager->updateUser($user);

            $dispatcher->dispatch(WSUserEvents::PASSWORD_COMPLETED, new UserEvent($user, $request));
        } else {
            $dispatcher->dispatch(WSUserEvents::PASSWORD_ERROR, new UserEvent($user, $request));
        }

        return $this->redirect($this->generateUrl('ws_user_user_list'));
    }
}
