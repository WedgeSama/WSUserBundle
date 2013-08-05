<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use WS\UserBundle\DependencyInjection\Compiler\FormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WSUserBundle extends Bundle {
	public function build(ContainerBuilder $container) {
		parent::build($container);
		$container->addCompilerPass(new FormPass());
	}
}
