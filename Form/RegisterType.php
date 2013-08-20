<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\True;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('username', null, 
                array(
                        'label' => 'form.username', 
                        'translation_domain' => 'WSUserBundle' 
                ))
            ->add('email', 'repeated', 
                array(
                        'type' => 'email', 
                        'options' => array(
                                'translation_domain' => 'WSUserBundle'
                        ), 
                        'first_options' => array(
                                'label' => 'form.email'
                        ), 
                        'second_options' => array(
                                'label' => 'form.email_conf'
                        ), 
                        'invalid_message' => 'ws_user_bundle.user.email.same' 
                ))
            ->add('pass', 'repeated', 
                array(
                        'type' => 'password', 
                        'options' => array(
                                'translation_domain' => 'WSUserBundle' 
                        ), 
                        'first_options' => array(
                                'label' => 'form.pass'
                        ), 
                        'second_options' => array(
                                'label' => 'form.pass_conf'
                        ), 
                        'invalid_message' => 'ws_user_bundle.user.pass.same' 
                ))
            ->add('accept', 'checkbox', 
                array(
                        'label' => 'register.accept', 
                        'translation_domain' => 'WSUserBundle', 
                        'mapped' => false, 
                        'constraints' => new True(
                                array(
                                        'message' => 'ws_user_bundle.user.accept' 
                                )) 
                ))
            ->add('submit', 'submit', 
                array(
                        'label' => 'register.submit', 
                        'translation_domain' => 'WSUserBundle'
                ));
    }

    public function getName() {
        return 'ws_user_bundle_register_type';
    }

}