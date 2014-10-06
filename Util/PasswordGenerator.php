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

use FOS\UserBundle\Util\TokenGenerator;

/**
 * Password generator.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class PasswordGenerator implements PasswordGeneratorInterface
{
    private $generator;

    public function __construct(TokenGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function generatePassword()
    {
        return substr($this->generator->generateToken(), 0, 12);
    }
}