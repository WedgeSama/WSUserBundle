<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Provider;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserProvider implements UserProviderInterface {

    /**
     * @var \WS\UserBundle\Model\UserRepository
     */
    protected $repo;

    protected $filter;

    /**
     * Constructor
     * @param UserRepository $repo
     * @param string $name
     * @param string $filter
     */
    public function __construct(EntityManager $em, $name, $filter) {
        $this->repo = $em->getRepository($name);
        $this->filter = $filter;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username) {
        switch ($this->filter) {
            case 'email' :
                $user = $this->repo->findOneByEmail($username);
                break;
            case 'both' :
                $user = filter_var($username, FILTER_VALIDATE_EMAIL) ? $this->repo->findOneByEmail(
                        $username) : $this->repo->findOneByUsername($username);
                break;
            default :
                $user = $this->repo->findOneByUsername($username);
        }
        
        if (! $user)
            throw new UsernameNotFoundException(
                    sprintf("User not found: %s", $username));
        
        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user) {
        $class = get_class($user);
        
        if (! $this->supportsClass($class))
            throw new UnsupportedUserException(
                    sprintf('Instances of "%s" are not supported.', $class));
        
        return $this->repo->findOneById($user->getId());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class) {
        return $this->repo->entityNameGetter() === $class ||
                 is_subclass_of($class, $this->repo->entityNameGetter());
    }

}