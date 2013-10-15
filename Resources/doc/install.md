WSUserBundle Installation
==================================

## Prerequisites

This bundle requires 
- Symfony 2.3+.
- [FOSUserBundle] (https://github.com/FriendsOfSymfony/FOSUserBundle)

## Installation

### Step 1: Download WSUserBundle using composer

Add WSUserBundle in your composer.json:

```js
{
    "require": {
        "wedgesama/user-bundle": "dev-master",
    }
}
```

Now tell composer to download the bundle with this command:

``` bash
$ php composer.phar update wedgesama/user-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new WS\UserBundle\WSUserBundle()
    );
}
```
