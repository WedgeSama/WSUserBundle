<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Doctrine;

use FOS\UserBundle\Doctrine\UserManager as BaseManager;
use FOS\UserBundle\Model\UserInterface;

/**
 * Custom User manager.
 *
 * @author Benjamin Georgeault <github@wedgesama.fr>
 */
class UserManager extends BaseManager
{
    /**
     * Use for pagination.
     *
     * @return mixed
     */
    public function queryUsers()
    {
        $qb = $this->repository->createQueryBuilder('u');

        return $qb->getQuery();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }
}