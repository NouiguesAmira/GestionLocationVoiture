<?php

namespace App\Repository;

use App\Entity\Marque;
use Doctrine\ORM\EntityRepository;

class MarqueRepository extends EntityRepository
{
    /**
     * @return Marque[]
     */
    public function findWithDisponibleVoitures()
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->innerJoin('c.voitures', 'j')
            ->andWhere('j.disponible = :disponible')
            ->setParameter('disponible', true)
            ->getQuery()
            ->getResult();
    }
   
}
