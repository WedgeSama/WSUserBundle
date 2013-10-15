<?php
namespace WS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WSUserBundle extends Bundle {

    public function getParent() {
        return 'FOSUserBundle';
    }
}
