<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Model;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {

    /**
     * Get entity name
     * 
     * @return string
     */
    public function entityNameGetter() {
        return $this->_entityName;
    }

    /**
     * Create a new User object
     * 
     * @return UserInterface
     */
    public function createUser() {
        $name = $this->_entityName;
        
        return new $name();
    }

}