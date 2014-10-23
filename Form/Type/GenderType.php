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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * A form for gender field.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class GenderType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices'=> array(
                'm' => 'form.gender.m',
                'f' => 'form.gender.f',
                'o' => 'form.gender.o',
            ),
            'translation_domain' => 'WSUserBundle',
            'label' => 'entity.user.gender',
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ws_gender';
    }

}
