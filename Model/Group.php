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

/**
 * @Orm\MappedSuperclass
 */
abstract class Group implements GroupInterface {

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
     * @ORM\Column(name="name", type="string", length=25)
     */
    protected $name;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    protected $roles;

    /**
     * Has to be override by child
     */
    protected $users;

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
    public function setName($name) {
        $this->name = $name;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getName() {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function addRole($role) {
        if (! $this->hasRole($role))
            $this->roles[] = strtoupper($role);
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasRole($role) {
        return in_array(strtoupper($role), $this->roles, true);
    }

    /**
     * {@inheritDoc}
     */
    public function removeRole($role) {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setRoles(array $roles) {
        $this->roles = $roles;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsers() {
        return $this->users ?  : $this->users = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function addUser($user) {
        $users = $this->getUsers();
        if (! $users->contains($user))
            $users->add($user);
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeUser($user) {
        $users = $this->getUsers();
        if ($users->contains($user))
            $users->removeElement($user);
        
        return $this;
    }

}
