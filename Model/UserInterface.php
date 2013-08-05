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

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

interface UserInterface extends AdvancedUserInterface, EquatableInterface, \Serializable {
    const ROLE_DEFAULT = 'ROLE_USER';

    /**
     * Set username.
     * 
     * @param string $username
     * @return self
     */
    public function setUsername($username);

    /**
     * Get email.
     * 
     * @return string
     */
    public function getEmail();

    /**
     * Set email.
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email);
    
    /**
     * Set salt.
     *
     * @param string $salt
     * @return self
     */
    public function setSalt($salt);

    /**
     * Set password.
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password);

    /**
     * @param boolean $boolean
     * @return self
     */
    public function setEnabled($boolean);

    /**
     * Get the datetime of last login
     *
     * @return null|\DateTime
     */
    public function getLastLoginAt();

    /**
     * Set the datetime of last login
     *
     * @param null|\DateTime $lastLoginAt
     * @return self
     */
    public function setLastLoginAt(\DateTime $lastLoginAt = null);
    
    /**
     * Get user's token
     * 
     * @return null|string
     */
    public function getToken();
    
    /**
     * Set user's token
     *
     * @param null|string $token
     * @return self
     */
    public function setToken($token = null);
    
    /**
     * Get the token's expiration date
     * 
     * @return null|\DateTime $tokenExpireAt
     */
    public function getTokenExpireAt();
    
    /**
     * Get the token's expiration date
     *
     * @param null|\DateTime $tokenExpireAt
     * @return self
     */
    public function setTokenExpireAt(\DateTime $tokenExpireAt = null);
	
	/**
	 * @param \Symfony\Component\Security\Core\Role\Role $role
	 * @return boolean
	 */
	public function hasRole($role);

    /**
     * Get user's groups
	 *
     * @return GroupInterface[]
     */
    public function getGroups();
    
    /**
     * Get user's groups's name
     *
     * @return string[]
     */
    public function getGroupsNames();
	
	/**
	 * Add user to a group
	 * 
	 * @param GroupInterface $group
	 * @return self
	 */
	public function addGroup(GroupInterface $group);
	
	/**
	 * Check if the user is in the group
	 *
	 * @param string $groupName name of a group
	 * @return boolean
	 */
	public function hasGroup($groupName);
	
	/**
	 * Remove the user from a group
	 * 
	 * @param GroupInterface $group
	 * @return self
	 */
	public function removeGroup(GroupInterface $group);
	
	/**
	 * @return null|\DateTime
	 */
	public function getCredentialsExpireAt();
	
	/**
	 * @param null|\DateTime $credentialsExpireAt
	 * @return self
	 */
	public function setCredentialsExpireAt(\DateTime $credentialsExpireAt = null);
	
	/**
	 * @return null|\DateTime
	 */
	public function getExpireAt();
	
	/**
	 * @param null|\DateTime $expireAt
	 * @return self
	 */
	public function setExpireAt(\DateTime $expireAt = null);
	
	/**
	 * @return null|\DateTime
	 */
	public function getLockExpireAt();
	
	/**
	 * @param null|\DateTime $locketAt
	 * @return self
	 */
	public function setLockExpireAt(\DateTime $expireAt = null);
	
	/**
	 * @return null|\DateTime
	 */
	public function getCreateAt();
	
	/**
	 * Get plaintext pass
	 *
	 * @return null|string
	 */
	public function getPass();
	
	/**
	 * Set plaintext pass
	 *
	 * @param string $pass
	 * @return self
	 */
	public function setPass($pass);
}