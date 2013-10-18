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

use Symfony\Component\Form\FormBuilderInterface;

class EditUserType extends UserType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        
        $builder->add('plainPassword', null, 
                array(
                        'required' => false 
                ));
        
        $builder->add('submit', 'submit',
                array(
                        'label' => 'form.buttons.user.edit'
                ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'ws_userbundle_edituser';
    }

}
