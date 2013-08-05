<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormPass implements CompilerPassInterface {
	public function process(ContainerBuilder $container) {
		$resources = $container->getParameter('twig.form.resources');
		
		$resources[] = 'WSUserBundle:Form:js_layout.html.twig';
		$resources[] = 'WSUserBundle:Form:div_layout.html.twig';
		
		$container->setParameter('twig.form.resources', $resources);
	}
}