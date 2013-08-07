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
use Symfony\Component\Validator\Constraints\Length;

class PasswordAskType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('username', null, 
                array(
                        'label' => 'form.username', 
                        'translation_domain' => 'WSUserBundle', 
                        'constraints' => new Length(
                                array(
                                        'min' => 2, 
                                        'max' => 60, 
                                        'minMessage' => 'ws_tools_bundle.length.min', 
                                        'maxMessage' => 'ws_tools_bundle.length.max' 
                                )) 
                ))
            ->add('submit', 'submit', 
                array(
                        'label' => 'password.submit.ask', 
                        'translation_domain' => 'WSUserBundle' 
                ));
    }

    public function getName() {
        return 'ws_user_bundle_password_ask_type';
    }

}