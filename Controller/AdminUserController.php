<?php

namespace WS\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Admin User controller.
 *
 */
class AdminUserController extends Controller {

    /**
     * Lists all User entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()
            ->getManager();
        
        $className = $this->container->getParameter('fos_user.model.user.class');
        $page = $this->get('request')->query->get('page', 1);
        
        $query = $em->getRepository($className)
            ->queryAll();
        
        $paginator = $this->get('knp_paginator');
        $users = $paginator->paginate($query, $page);
        
        return $this->render('WSUserBundle:AdminUser:index.html.twig', 
                array(
                        'users' => $users 
                ));
    }

    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request) {
        $userManager = $this->container->get('fos_user.user_manager');
        
        $user = $userManager->createUser();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $mailer = $this->container->get('ws_tools.mailer');
            $msg = $mailer->prepareMail(
                    'WSUserBundle:AdminUser:create.email.twig', 
                    'email.user.create.subject', 
                    array(
                            'user' => $user, 
                            'url' => $this->generateUrl(
                                    'fos_user_security_login', array(), true) 
                    ), 'WSuserBundle', 
                    array(
                            '%username%' => $user->getusername() 
                    ));
            
            $em = $this->getDoctrine()
                ->getManager();
            $this->get('fos_user.user_manager')
                ->updateUser($user, false);
            $em->flush();
            
            $mailer->send($msg);
            
            return $this->redirect(
                    $this->generateUrl('ws_user_bundle_user_show', 
                            array(
                                    'id' => $user->getId() 
                            )));
        }
        
        return $this->render('WSUserBundle:AdminUser:new.html.twig', 
                array(
                        'entity' => $user, 
                        'form' => $form->createView() 
                ));
    }

    /**
    * Creates a form to create a User entity.
    *
    * @param User $user The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    protected function createCreateForm($user) {
        $className = $this->container->getParameter('fos_user.model.user.class');
        $formName = $this->container->getParameter('ws_user.user.new_form');
        
        $form = $this->createForm(new $formName($className), $user, 
                array(
                        'action' => $this->generateUrl(
                                'ws_user_bundle_user_create'), 
                        'method' => 'POST' 
                ));
        
        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction() {
        $userManager = $this->container->get('fos_user.user_manager');
        
        $user = $userManager->createUser();
        $form = $this->createCreateForm($user);
        
        return $this->render('WSUserBundle:AdminUser:new.html.twig', 
                array(
                        'entity' => $user, 
                        'form' => $form->createView() 
                ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id) {
        $className = $this->container->getParameter('fos_user.model.user.class');
        
        $em = $this->getDoctrine()
            ->getManager();
        
        $user = $em->getRepository($className)
            ->find($id);
        
        if (! $user)
            throw $this->createNotFoundException('Unable to find User entity.');
        
        return $this->render('WSUserBundle:AdminUser:show.html.twig', 
                array(
                        'user' => $user, 
                ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id) {
        $className = $this->container->getParameter('fos_user.model.user.class');
        
        $em = $this->getDoctrine()
            ->getManager();
        
        $user = $em->getRepository($className)
            ->find($id);
        
        if (! $user)
            throw $this->createNotFoundException('Unable to find User entity.');
        
        $editForm = $this->createEditForm($user);
        
        return $this->render('WSUserBundle:AdminUser:edit.html.twig', 
                array(
                        'entity' => $user, 
                        'edit_form' => $editForm->createView(), 
                ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $user The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm($user) {
        $className = $this->container->getParameter('fos_user.model.user.class');
        $formName = $this->container->getParameter('ws_user.user.edit_form');
        
        $form = $this->createForm(new $formName($className), $user, 
                array(
                        'action' => $this->generateUrl(
                                'ws_user_bundle_user_update', 
                                array(
                                        'id' => $user->getId() 
                                )), 
                        'method' => 'POST' 
                ));
        
        $form->add('submit', 'submit', 
                array(
                        'label' => 'Update' 
                ));
        
        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $className = $this->container->getParameter('fos_user.model.user.class');
        
        $em = $this->getDoctrine()
            ->getManager();
        
        $user = $em->getRepository($className)
            ->find($id);
        
        if (! $user)
            throw $this->createNotFoundException('Unable to find User entity.');
        
        $editForm = $this->createEditForm($user);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            
            $sendMail = false;
            if ($user->getPlainPassword() != null)
                $sendMail = true;
            
            if ($sendMail) {
                $mailer = $this->container->get('ws_tools.mailer');
                $msg = $mailer->prepareMail(
                        'WSUserBundle:AdminUser:edit.email.twig', 
                        'email.user.edit.subject', 
                        array(
                                'user' => $user, 
                                'url' => $this->generateUrl(
                                        'fos_user_security_login', array(), true) 
                        ), 'WSuserBundle', 
                        array(
                                '%username%' => $user->getusername() 
                        ));
            }
            
            $this->get('fos_user.user_manager')
                ->updateUser($user, false);
            
            $em->flush();
            
            if ($sendMail)
                $mailer->send($msg);
            
            return $this->redirect(
                    $this->generateUrl('ws_user_bundle_user_edit', 
                            array(
                                    'id' => $id 
                            )));
        }
        
        return $this->render('WSUserBundle:AdminUser:edit.html.twig', 
                array(
                        'entity' => $user, 
                        'edit_form' => $editForm->createView(), 
                ));
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $className = $this->container->getParameter('fos_user.model.user.class');
        
        $em = $this->getDoctrine()
            ->getManager();
        $user = $em->getRepository($className)
            ->find($id);
        
        if (! $user)
            throw $this->createNotFoundException('Unable to find User entity.');
        
        $em->remove($user);
        $em->flush();
        
        return $this->redirect($this->generateUrl('ws_user_bundle_user_list'));
    }

}
