<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * User entity with some common fields.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
abstract class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var \DateTime
     */
    protected $registerAt;
    
    /**
     * @var string
     */
    protected $ip;

    /**
     * @var \DateTime
     */
    protected $birthAt;

    public function __construct()
    {
        parent::__construct();
        
        $this->registerAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set last name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        
        return $this;
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set first name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        
        return $this;
    }

    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set registerAt
     *
     * @param \DateTime $registerAt            
     * @return User
     */
    public function setRegisterAt($registerAt)
    {
        $this->registerAt = $registerAt;
        
        return $this;
    }

    /**
     * Get registerAt
     *
     * @return \DateTime
     */
    public function getRegisterAt()
    {
        return $this->registerAt;
    }

    /**
     * Get expiresAt
     * 
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Get credentialsExpireAt
     * 
     * @return \DateTime
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }
    
    /**
     * Set ip
     *
     * @param string $ip
     * @return User
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }
    
    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set date of birth.
     *
     * @param \DateTime $birthAt
     */
    public function setBirthAt($birthAt)
    {
        $this->birthAt = $birthAt;
    }

    /**
     * Get date of birth.
     *
     * @return \DateTime
     */
    public function getBirthAt()
    {
        return $this->birthAt;
    }



}