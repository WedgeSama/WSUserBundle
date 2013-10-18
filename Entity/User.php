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

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\MappedSuperclass
 */
class User extends BaseUser {

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var string @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected $lastname;

    /**
     *
     * @var string @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     *
     * @var \DateTime @ORM\Column(name="birth_at", type="datetime", nullable=true)
     */
    protected $birthAt;

    /**
     *
     * @var string @ORM\Column(name="sexe", type="string", length=1, nullable=true)
     */
    protected $sexe;
    
    /**
     *
     * @var string @ORM\Column(name="ip", type="string", length=40, nullable=true)
     */
    protected $ip;

    /**
     *
     * @var \DateTime @ORM\Column(name="register_at", type="datetime")
     */
    protected $registerAt;

    public function __construct() {
        parent::__construct();
        
        $this->registerAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set lastname
     *
     * @param string $lastname           
     * @return User
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;
        
        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname            
     * @return User
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Set birthAt
     *
     * @param \DateTime $birthAt            
     * @return User
     */
    public function setBirthAt($birthAt) {
        $this->birthAt = $birthAt;
        
        return $this;
    }

    /**
     * Get birthAt
     *
     * @return \DateTime
     */
    public function getBirthAt() {
        return $this->birthAt;
    }

    /**
     * Set sexe
     *
     * @param string $sexe            
     * @return User
     */
    public function setSexe($sexe) {
        $this->sexe = $sexe;
        
        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe() {
        return $this->sexe;
    }

    /**
     * Set registerAt
     *
     * @param \DateTime $registerAt            
     * @return User
     */
    public function setRegisterAt($registerAt) {
        $this->registerAt = $registerAt;
        
        return $this;
    }

    /**
     * Get registerAt
     *
     * @return \DateTime
     */
    public function getRegisterAt() {
        return $this->registerAt;
    }

    /**
     * Get expiresAt
     * 
     * @return \DateTime
     */
    public function getExpiresAt() {
        return $this->expiresAt;
    }

    /**
     * Get credentialsExpireAt
     * 
     * @return \DateTime
     */
    public function getCredentialsExpireAt() {
        return $this->credentialsExpireAt;
    }
    
    /**
     * Set ip
     *
     * @param string $ip
     * @return User
     */
    public function setIp($ip) {
        $this->ip = $ip;
    
        return $this;
    }
    
    /**
     * Get ip
     *
     * @return string
     */
    public function getIp() {
        return $this->ip;
    }

}