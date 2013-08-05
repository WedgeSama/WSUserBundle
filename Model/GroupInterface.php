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

interface GroupInterface {

    /**
     * Get group's name
	 * @return string
     */
    public function getName();

    /**
     * Set group's name
	 * 
	 * @param string $name
	 * @return self
     */
    public function setName($name);

    /**
     * Get group's roles
     * @return Symfony\Component\Security\Core\Role\Role[]
     */
    public function getRoles();

    /**
	 * @param string $role
	 * @return boolean
	 */
    public function hasRole($role);

    /**
	 * Set the roles of the group.
	 *
	 * @param Symfony\Component\Security\Core\Role\Role[] $roles
	 * @return self
	 */
    public function setRoles(array $roles);

    /**
	 * Add a role to the group.
	 *
	 * @param string $role
	 * @return self
	 */
    public function addRole($role);

    /**
	 * Remove a role to the group.
	 *
	 * @param string $role
	 * @return self
	 */
    public function removeRole($role);

    /**
     * Get group's users
	 * 
     * @return UserInterface
     */
    public function getUsers();

    /**
     * Add a user to the group.
     *
     * @param UserInterface $user
     * @return self
     */
    public function addUser($user);

    /**
     * Remove a user from the group.
     *
     * @param UserInterface $user
     * @return self
     */
    public function removeUser($user);

}