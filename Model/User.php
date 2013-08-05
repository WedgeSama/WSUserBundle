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

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @Orm\MappedSuperclass
 * 
 * @UniqueEntity(fields={"username"}, message="ws_user_bundle.user.username.unique")
 * @UniqueEntity(fields={"email"}, message="ws_user_bundle.user.email.unique")
 */
abstract class User implements UserInterface {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="ws_user_bundle.user.username.notBlank")
     * @Assert\Length(
     *      min = "2",
     *      max = "25",
     *      minMessage = "ws_tools_bundle.length.min",
     *      maxMessage = "ws_tools_bundle.length.max"
     * )
     */
    protected $username;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    protected $salt;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="ws_user_bundle.user.pass.notBlank")
     * @Assert\Length(
     *      min = "8",
     *      minMessage = "ws_tools_bundle.length.min"
     * )
     * @Assert\Regex(pattern = "/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", message="ws_user_bundle.user.pass.regex")
     */
    protected $pass;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="ws_user_bundle.user.email.notBlank")
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\Length(
     *      min = "6",
     *      max = "60",
     *      minMessage = "ws_tools_bundle.length.min",
     *      maxMessage = "ws_tools_bundle.length.max"
     * )
     * @Assert\Email(message = "ws_user_bundle.user.email.invalid", checkMX = true)
     */
    protected $email;

    /**
     * @ORM\Column(name="enable", type="boolean")
     */
    protected $enable;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=23, nullable=true)
     */
    protected $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="token_expire_at", type="datetime", nullable=true)
     */
    protected $tokenExpireAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lock_expire_at", type="datetime", nullable=true)
     * @Assert\DateTime(message="ws_tools_bundle.datetime")
     */
    protected $lockExpireAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    protected $createAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login_at", type="datetime", nullable=true)
     */
    protected $lastLoginAt;

    /**
     * Has to be override by child
     */
    protected $groups;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="credentials_expire_at", type="datetime", nullable=true)
     * @Assert\DateTime(message="ws_tools_bundle.datetime")
     */
    protected $credentialsExpireAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expire_at", type="datetime", nullable=true)
     * @Assert\DateTime(message="ws_tools_bundle.datetime")
     */
    protected $expireAt;

    public function __construct() {
        $this->enable = false;
        $this->createAt = new \DateTime();
        $this->salt = sha1(uniqid(null, true));
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
     * {@inheritDoc}
     */
    public function setUsername($username) {
        $this->username = $username;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * {@inheritDoc}
     */
    public function setSalt($salt) {
        $this->salt = $salt;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * {@inheritDoc}
     */
    public function setPassword($password) {
        $this->password = $password;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail($email) {
        $this->email = $email;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * {@inheritDoc}
     */
    public function setEnabled($enable) {
        $this->enable = $enable;
        
        return $this;
    }

    /**
     * {@inheritDoc} 
     */
    public function isEnabled() {
        return $this->enable;
    }

    /**
     * {@inheritDoc}
     */
    public function setToken($token = null) {
        $this->token = $token;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * {@inheritDoc}
     */
    public function setTokenExpireAt(\DateTime $tokenExpireAt = null) {
        $this->tokenExpireAt = $tokenExpireAt;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenExpireAt() {
        return $this->tokenExpireAt;
    }

    /**
     * {@inheritDoc} 
     */
    public function getCreateAt() {
        return $this->createAt;
    }

    /**
     * {@inheritDoc}
     */
    public function setLastLoginAt(\DateTime $locketAt = null) {
        $this->lastLoginAt = $lastLoginAt;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastLoginAt() {
        return $this->lastLoginAt;
    }

    /**
     * {@inheritDoc}
     */
    public function getGroups() {
        return $this->groups ?  : $this->groups = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function getGroupsNames() {
        $names = array();
        foreach ($this->getGroups() as $group)
            $names[] = $group->getName();
        
        return $names;
    }

    /**
     * {@inheritDoc}
     */
    public function addGroup(GroupInterface $group) {
        $groups = $this->getGroups();
        if (! $groups->contains($group))
            $groups->add($group);
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasGroup($groupName) {
        return in_array($groupName, $this->getGroupsNames());
    }

    /**
     * {@inheritDoc}
     */
    public function removeGroup(GroupInterface $group) {
        $groups = $this->getGroups();
        if ($groups->contains($group))
            $groups->removeElement($group);
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCredentialsExpireAt() {
        return $this->credentialsExpireAt;
    }

    /**
     * {@inheritDoc}
     */
    public function setCredentialsExpireAt(\DateTime $credentialsExpireAt = null) {
        $this->credentialsExpireAt = $credentialsExpireAt;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getExpireAt() {
        $this->expireAt;
    }

    /**
     * {@inheritDoc}
     */
    public function setExpireAt(\DateTime $expireAt = null) {
        $this->expireAt = $expireAt;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLockExpireAt() {
        $this->lockExpireAt;
    }

    /**
     * {@inheritDoc}
     */
    public function setLockExpireAt(\DateTime $expireAt = null) {
        $this->lockExpireAt = $expireAt;
        
        return $this;
    }

    public function getRoles() {
        $roles = array(
                static::ROLE_DEFAULT 
        );
        foreach ($this->getGroups() as $group)
            $roles = array_merge($roles, $group->getRoles());
        
        return array_unique($roles);
    }

    /**
     * {@inheritDoc}
     */
    public function hasRole($role) {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials() {
        $this->pass = null;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize() {
        return serialize(
                array(
                        $this->id, 
                        $this->username, 
                        $this->salt, 
                        $this->password 
                ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized) {
        list ($this->id, $this->username, $this->salt, $this->password) = unserialize(
                $serialized);
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonExpired() {
        if (! $this->expireAt || $this->expireAt->getTimestamp() > time())
            return true;
        
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonLocked() {
        if (! $this->lockExpireAt || $this->lockExpireAt->getTimestamp() < time())
            return true;
        
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isCredentialsNonExpired() {
        if (! $this->credentialsExpireAt ||
                 $this->credentialsExpireAt->getTimestamp() > time())
            return true;
        
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isEqualTo(
       \Symfony\Component\Security\Core\User\UserInterface $user) {
        return $this->id === $user->id && $this->username === $user->username &&
                 $this->salt === $user->salt &&
                 $this->password === $user->password;
    }

    /**
     * {@inheritDoc}
     */
    public function getPass() {
        return $this->pass;
    }

    /**
     * {@inheritDoc}
     */
    public function setPass($pass) {
        $this->pass = $pass;
        return $this;
    }

}