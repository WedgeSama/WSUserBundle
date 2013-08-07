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

class Configuration implements ConfigurationInterface {
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ws_user');
        $this->addMain($rootNode);
        $this->addSecurity($rootNode);
        $this->addRegister($rootNode);
        $this->addPassword($rootNode);

        return $treeBuilder;
    }
    
    private function addMain(ArrayNodeDefinition $rootNode) {
        $rootNode
            ->children()
                ->scalarNode('user_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('token_expire')
                    ->defaultValue('PT24H')
                ->end()
                ->scalarNode('firewall_name')
                    ->defaultValue('main')
                ->end()
            ->end();
    }
    
    private function addSecurity(ArrayNodeDefinition $rootNode) {
        $rootNode
            ->children()
                ->arrayNode('security')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('login_by')
                            ->defaultValue('username')
                            ->validate()
                            ->ifNotInArray(array('username', 'email', 'both'))
                                ->thenInvalid('Invalid login_by "%s"')
                            ->end()
                        ->end()
                        ->scalarNode('path_login')
                            ->defaultValue('/login')
                        ->end()
                        ->scalarNode('path_login_check')
                            ->defaultValue('/login_check')
                        ->end()
                        ->scalarNode('path_logout')
                            ->defaultValue('/logout')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    
    private function addRegister(ArrayNodeDefinition $rootNode) {
        $rootNode
            ->children()
                ->arrayNode('register')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('form_class')
                            ->defaultValue('WS\\UserBundle\\Form\\RegisterType')
                        ->end()
                        ->booleanNode('check_email')
                            ->defaultTrue()
                        ->end()
                        ->scalarNode('path_register')
                            ->defaultValue('/register')
                        ->end()
                        ->scalarNode('path_wait')
                            ->defaultValue('/wait-email')
                        ->end()
                        ->scalarNode('path_confirm')
                            ->defaultValue('/register-confirm')
                        ->end()
                        ->scalarNode('path_check')
                            ->defaultValue('/check-email')
                        ->end()
                        ->scalarNode('sender_email')
                            ->defaultValue('no-replay@no-replay.com')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    
    private function addPassword(ArrayNodeDefinition $rootNode) {
        $rootNode
            ->children()
                ->arrayNode('password_reset')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('form_class_ask')
                            ->defaultValue('WS\\UserBundle\\Form\\PasswordAskType')
                        ->end()
                        ->scalarNode('form_class_reset')
                            ->defaultValue('WS\\UserBundle\\Form\\PasswordResetType')
                        ->end()
                        ->scalarNode('path_ask')
                            ->defaultValue('/ask-password')
                        ->end()
                        ->scalarNode('path_send')
                            ->defaultValue('/send-email')
                        ->end()
                        ->scalarNode('path_reset')
                            ->defaultValue('/enter-password')
                        ->end()
                        ->scalarNode('path_confirm')
                            ->defaultValue('/confirm-password')
                        ->end()
                        ->scalarNode('sender_email')
                            ->defaultValue('no-replay@no-replay.com')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}