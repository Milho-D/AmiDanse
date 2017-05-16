<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Courant;

/**
 * TypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TypeRepository extends \Doctrine\ORM\EntityRepository
{
    function findByCourants(Courant $courant){

        $qb = $this->createQueryBuilder("t")
            ->where(':courant MEMBER OF t.courants')
            ->setParameters(array('courant' => $courant));

        return $qb->getQuery()->getArrayResult();

    }
}
