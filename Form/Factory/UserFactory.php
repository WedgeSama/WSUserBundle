<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Form\Factory;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Router;

/**
 * Generate forms.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class UserFactory
{
    protected $formFactory;

    protected $router;

    protected $userClass;

    protected $newClass;

    protected $editClass;

    public function __construct(FormFactoryInterface $formFactory, Router $router, $userClass, $newClass, $editClass)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->userClass = $userClass;
        $this->newClass = $newClass;
        $this->editClass = $editClass;
    }

    /**
     * Create a form to create a User.
     *
     * @param UserInterface $user
     * @param array $options
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createNewForm(UserInterface $user)
    {
        $form = $this->formFactory->create(new $this->newClass($this->userClass), $user, array(
            'validation_groups' => array('ws_user.user.new'),
        ));

        return $form;
    }

    /**
     * Create a form to edit a User.
     *
     * @param UserInterface $user
     * @param array $options
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createEditForm(UserInterface $user)
    {
        $form = $this->formFactory->create(new $this->editClass($this->userClass), $user, array(
            'validation_groups' => array('ws_user.user.edit'),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Create a form to delete a User.
     *
     * @param string $username
     * @return \Symfony\Component\Form\Form
     */
    public function createDeleteForm($username = '__USERNAME__')
    {
        $builder = $this->formFactory->createBuilder('form');

        $builder
            ->setAction($this->router->generate('ws_user_user_delete', array(
                'username' => $username,
            )))
            ->setMethod('DELETE');

        return $builder->getForm();
    }

    /**
     * Create a form to update a User password.
     *
     * @param string $username
     * @return \Symfony\Component\Form\Form
     */
    public function createPasswordForm($username = '__USERNAME__')
    {
        $builder = $this->formFactory->createBuilder('form');

        $builder
            ->setAction($this->router->generate('ws_user_user_password', array(
                'username' => $username,
            )))
            ->setMethod('POST');

        return $builder->getForm();
    }
}
