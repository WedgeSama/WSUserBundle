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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * Bundle configuration.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ws_user');
        
        $this->addUser($rootNode);
        $this->addSecurity($rootNode);
        $this->addUtils($rootNode);
        
        return $treeBuilder;
    }
    
    private function addUser(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('user')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('new')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('form')
                                    ->defaultValue("WS\\UserBundle\\Form\\Type\\UserType")
                                ->end()
                                ->arrayNode('email')
                                    ->children()
                                        ->arrayNode('from')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('address')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                                ->scalarNode('sender_name')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->scalarNode('template')
                                            ->defaultValue("WSUserBundle:User:email/new.email.twig")
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('edit')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('form')
                                    ->defaultValue("WS\\UserBundle\\Form\\Type\\UserType")
                                ->end()
                                ->arrayNode('email')
                                    ->children()
                                        ->arrayNode('from')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('address')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                                ->scalarNode('sender_name')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->scalarNode('template')
                                            ->defaultValue("WSUserBundle:User:email/edit.email.twig")
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('delete')
                            ->children()
                                ->arrayNode('email')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('from')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('address')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                                ->scalarNode('sender_name')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->scalarNode('template')
                                            ->defaultValue("WSUserBundle:User:email/delete.email.twig")
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('password')
                            ->children()
                                ->arrayNode('email')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('from')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('address')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                                ->scalarNode('sender_name')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->scalarNode('template')
                                            ->defaultValue("WSUserBundle:User:email/password.email.twig")
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('disable')
                            ->children()
                                ->arrayNode('email')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('from')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('address')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                                ->scalarNode('sender_name')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->scalarNode('template')
                                            ->defaultValue("WSUserBundle:User:email/disable.email.twig")
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('blocked')
                            ->children()
                                ->arrayNode('email')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->arrayNode('from')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('address')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                                ->scalarNode('sender_name')
                                                    ->defaultValue('%mailer_user%')
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->scalarNode('template')
                                            ->defaultValue("WSUserBundle:User:email/blocked.email.twig")
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    
    private function addSecurity(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('security')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('allow_display_error')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('account_expired')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('authentication_credentials_not_found_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('authentication_service_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('bad_credentials_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('cookie_theft_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('credentials_expired_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('disabled_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('insufficient_authentication_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('invalid_csrf_token_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('locked_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('nonce_expired_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('provider_not_found_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('session_unavailable_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('token_not_found_exception')
                                    ->defaultTrue()
                                ->end()
                                ->booleanNode('username_not_found_exception')
                                    ->defaultTrue()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addUtils(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('utils')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('password_generator')
                            ->defaultValue("WS\\UserBundle\\Util\\PasswordGenerator")
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
