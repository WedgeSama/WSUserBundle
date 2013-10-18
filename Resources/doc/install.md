WSUserBundle Installation
==================================

## Prerequisites

This bundle requires 
- Symfony 2.3+.
- [FOSUserBundle] (https://github.com/FriendsOfSymfony/FOSUserBundle)

## Installation

### Step 1: Download WSUserBundle using composer

Add WSUserBundle (and others) in your composer.json:

```js
{
    "require": {
        "wedgesama/tools-bundle" : "dev-master",
        "friendsofsymfony/user-bundle" : "~2.0@dev",
        "wedgesama/user-bundle": "dev-master",
    }
}
```

Now tell composer to download the bundle with this command:

``` bash
$ php composer.phar update wedgesama/user-bundle
```

### Step 2: Enable the bundle

Enable bundles in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FOS\UserBundle\FOSUserBundle(),
        new WS\ToolsBundle\WSToolsBundle(),
        new WS\UserBundle\WSUserBundle()
    );
}
```

### Step 3: Add routes

``` yaml
# app/routing.yml

# WSUserBundle
ws_user_user:
    resource: "@WSUserBundle/Resources/config/routing/admin_user.yml"
    prefix:   /admin/user

# FOSUserBundle
fos_user_security:
    resource: "@FOSUserBundle/Resources/config/routing/security.xml"

fos_user_profile:
    resource: "@FOSUserBundle/Resources/config/routing/profile.xml"
    prefix: /profile

fos_user_register:
    resource: "@FOSUserBundle/Resources/config/routing/registration.xml"
    prefix: /register

fos_user_resetting:
    resource: "@FOSUserBundle/Resources/config/routing/resetting.xml"
    prefix: /resetting

fos_user_change_password:
    resource: "@FOSUserBundle/Resources/config/routing/change_password.xml"
    prefix: /profile

fos_user_group:
    resource: "@FOSUserBundle/Resources/config/routing/group.xml"
    prefix: /group
```
