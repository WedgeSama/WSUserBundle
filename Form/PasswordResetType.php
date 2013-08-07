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

class PasswordResetType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('pass', 'repeated', 
                array(
                        'type' => 'password', 
                        'options' => array(
                                'translation_domain' => 'WSUserBundle' 
                        ), 
                        'first_options' => array(
                                'label' => 'form.pass_new' 
                        ), 
                        'second_options' => array(
                                'label' => 'form.pass_conf' 
                        ), 
                        'invalid_message' => 'ws_user_bundle.user.pass.same' 
                ))
            ->add('submit', 'submit', 
                array(
                        'label' => 'password.submit.reset', 
                        'translation_domain' => 'WSUserBundle' 
                ));
    }

    public function getName() {
        return 'ws_user_bundle_password_reset_type';
    }

}