<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class WSUserExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('listener.yml');
        $loader->load('orm.yml');
        $loader->load('form.yml');
        $loader->load('util.yml');
        $loader->load('mailer.yml');
        $loader->load('twig.yml');

        // Security part.
        $container->setParameter('ws_user.security.allow_display_error', $config['security']['allow_display_error']);

        // User config.
        $email = array();
        foreach ($config['user'] as $key => $value) {
            if (array_key_exists('form', $value)) {
                $container->setParameter('ws_user.user.'.$key.'.form', $value['form']);
            }

            if (array_key_exists('email', $value)) {
                $email[$key] = array(
                    'template' => $value['email']['template'],
                    'from' => array(
                        $value['email']['from']['address'] => $value['email']['from']['sender_name'],
                    ),
                );
            }
        }

        $container->setParameter('ws_user.user.emails', $email);

        // Utils part.
        $container->setParameter('ws_user.util.password_generator.class', $config['utils']['password_generator']);
    }
}
