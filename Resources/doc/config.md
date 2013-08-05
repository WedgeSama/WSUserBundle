WSUserBundle Configuration
==================================

Default configuration

``` yaml
# app/config/config.yml
ws_user:
    user_class: "MyBundle:User" # required, the name of your user entity
    token_expire: PT24H
    firewall_name: main
    security:
        login_by: username # can be username, email or both
        path_login: /login # if you change path, do not foget to update your firewall
        path_login_check: /login_check
        path_logout: /logout
    register:
        form_class: MyNamespace\MyBundle\Form\RegisterType
        check_email: true
        path_register: /register
        path_wait: /wait-email
        path_confirm: /register-confirm
        path_check: /check-email
        sender_email: no-replay@no-replay.com
```