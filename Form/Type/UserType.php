<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * A form for the entity WS\UserBundle\Entity\User.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class UserType extends AbstractType
{
    /**
     * The name of the data class
     *
     * @var string
     */
    protected $data_class;

    public function __construct($data_class)
    {
        $this->data_class = $data_class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                    'label' => 'entity.user.username'
                ))
            ->add('email', null, array(
                    'label' => 'entity.user.email'
                ))
            ->add('enabled', null, array(
                    'required' => false,
                    'label' => 'entity.user.enabled'
                ))
            ->add('locked', null, array(
                    'required' => false,
                    'label' => 'entity.user.locked'
                ))
            ->add('expired', null, array(
                    'required' => false,
                    'label' => 'entity.user.expired'
                ))
            ->add('expiresAt', null, array(
                    'required' => false,
                    'label' => 'entity.user.expiresat'
                ))
            ->add('credentialsExpired', null, array(
                    'required' => false,
                    'label' => 'entity.user.credentialsexpired'
                ))
            ->add('credentialsExpireAt', null, array(
                    'required' => false,
                    'label' => 'entity.user.credentialsexpiredat'
                ))
            ->add('lastname', null, array(
                    'required' => false,
                    'label' => 'entity.user.lastname'
                ))
            ->add('firstname', null, array(
                    'required' => false,
                    'label' => 'entity.user.firstname'
                ))
            ->add('birthAt', 'birthday', array(
                    'required' => false,
                    'label' => 'entity.user.birthat'
                ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->data_class,
            'translation_domain' => 'WSUserBundle'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ws_userbundle_user';
    }

}
