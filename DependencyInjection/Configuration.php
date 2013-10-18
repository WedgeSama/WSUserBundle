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
        
        $this->addUser($rootNode);
        
        return $treeBuilder;
    }
    
    private function addUser(ArrayNodeDefinition $rootNode) {
        $rootNode
            ->children()
                ->arrayNode('user')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('new_form')
                            ->defaultValue("WS\UserBundle\Form\UserType")
                        ->end()
                        ->scalarNode('edit_form')
                            ->defaultValue("WS\UserBundle\Form\EditUserType")
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
