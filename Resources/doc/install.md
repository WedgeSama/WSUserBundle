WSUserBundle Installation
==================================

## Prerequisites

This bundle requires 
- Symfony 2.3+.
- [WSToolsBundle](https://github.com/WedgeSama/WSToolsBundle)
- [JMSSecurityExtraBundle](http://jmsyst.com/bundles/JMSSecurityExtraBundle)

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

## Create your own UserBundle

### Step 1: Create the bundle and inherit from WSUserBundle
Create your own bundle for user management (ex: MyUserBundle) and edit the main file (MyUserBundle.php):

``` php
namespace My\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MyUserBundle extends Bundle {

    public function getParent() {
        return 'WSUserBundle';
    }

}
```

### Step 2: Create User and Group repositories

User Repository
``` php
namespace My\UserBundle\Entity\Repository;

use WS\UserBundle\Model\UserRepository as BaseRepository;

/**
 * UserRepository
 */
class UserRepository extends BaseRepository {

}
```

Group Repository
``` php
namespace My\UserBundle\Entity\Repository;

use WS\UserBundle\Model\GroupRepository as BaseRepository;

/**
 * GroupRepository
 */
class GroupRepository extends BaseRepository {

}

```

### Step 3: Create User and Group entities


User Entity
``` php
namespace My\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="My\UserBundle\Entity\Repository\UserRepository")
 */
class User extends BaseUser {
    
    /**
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     * @ORM\JoinTable(name="user_groups_link",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
}

```

Group Entity
``` php
namespace My\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WS\UserBundle\Model\Group as BaseGroup;

/**
 * Group
 *
 * @ORM\Table(name="user_groups")
 * @ORM\Entity(repositoryClass="My\UserBundle\Entity\Repository\GroupRepository")
 */
class Group extends BaseGroup {

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups", cascade={"detach"})
     */
    protected $users;

}
```

## Add routes

``` yaml
# app/config/routing.yml
WSUserBundle_security:
    resource: "@WSUserBundle/Resources/config/routing/security.yml"
    prefix:   /

WSUserBundle_register:
    resource: "@WSUserBundle/Resources/config/routing/register.yml"
    prefix:   /
```

## Configuration

``` yaml
# app/config/config.yml
ws_user:
    user_class: "MyBundle:User" # required, the name of your user entity
```

``` yaml
# app/config/security.yml
security:
    encoders:
        WS\UserBundle\Model\UserInterface: sha512
	
	providers:
        ws_userbundle:
            id: ws_user.user_provider

    firewalls:
        main:
            pattern: ^/
            form_login:
                provider: ws_userbundle
                csrf_provider: form.csrf_provider
            logout:
                invalidate_session: false
            anonymous:    true
```
