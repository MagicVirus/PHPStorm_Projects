<?php

namespace App\Repository;
/**
 * Created by PhpStorm.
 * User: ilbenjello
 * Date: 05/02/18
 * Time: 09:23
 */

use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    public function getModelArray($number = 30)
    {
        $dql = "SELECT * FROM Model ";
        return $this->getEntityManager()->createQuery($dql)
            ->setMaxResults($number)
            ->getArrayResult();
    }

    public function getViewerModels($userId, $number = 15)
    {
        $dql = "SELECT * FROM User WHERE id = ?1";

        return $this->getEntityManager()->createQuery($dql)
            ->setParameter(1, $userId)
            ->setMaxResults($number)
            ->getResult();
    }

    public function getModelFromXSD($XSDValidator)
    {
        $dql = "SELECT * FROM Model WHERE validator =?1";
        return $this->getEntityManager()->createQuerry()
            ->setParameter(1, $XSDValidator)
            ->getResult();
    }
}
