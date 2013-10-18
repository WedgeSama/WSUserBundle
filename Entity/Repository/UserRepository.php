<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository {

    public function queryAll() {
        $qb = $this->createQueryBuilder('u');
        
        return $qb->getQuery();
    }

}
