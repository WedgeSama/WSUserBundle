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

/**
 * Contains all events thrown in the WSUserBundle.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
final class WSUserEvents {
    
    /**
     * The SECURITY_ERROR_LOGIN is throw when an error occur during the login of user.
     */
    const SECURITY_ERROR_LOGIN = 'ws_user.security.error_login';

    const NEW_INITIALIZE = 'ws_user.user.new.initialize';

    const NEW_SUCCESS = 'ws_user.user.new.success';

    const NEW_COMPLETED = 'ws_user.user.new.completed';

    const NEW_ERROR = 'ws_user.user.new.error';

    const DELETE_INITIALIZE = 'ws_user.user.delete.initialize';

    const DELETE_SUCCESS = 'ws_user.user.delete.success';

    const DELETE_COMPLETED = 'ws_user.user.delete.completed';

    const DELETE_ERROR = 'ws_user.user.delete.error';

    const EDIT_INITIALIZE = 'ws_user.user.edit.initialize';

    const EDIT_SUCCESS = 'ws_user.user.edit.success';

    const EDIT_COMPLETED = 'ws_user.user.edit.completed';

    const EDIT_ERROR = 'ws_user.user.edit.error';

    const PASSWORD_INITIALIZE = 'ws_user.user.password.initialize';

    const PASSWORD_SUCCESS = 'ws_user.user.password.success';

    const PASSWORD_COMPLETED = 'ws_user.user.password.completed';

    const PASSWORD_ERROR = 'ws_user.user.password.error';
}
