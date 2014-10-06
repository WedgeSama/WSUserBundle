<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Util;

/**
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
interface PasswordGeneratorInterface
{
    public function generatePassword();
}