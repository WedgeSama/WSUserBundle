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

final class WSUserEvents {
    const REGISTER_START = 'ws_user.register.start';
    
    const REGISTER_REQUEST = 'ws_user.register.request';
    
    const REGISTER_CONFIRM = 'ws_user.register.confirm';
}