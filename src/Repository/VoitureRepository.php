<?php

namespace App\Repository;

use App\Entity\Marque;
use App\Entity\Voiture;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Voiture::class);
    }
    /**
     * @param int|null $marqueId
     *
     * @return Voiture[]
     */
    public function findDisponibleVoitures(int $marqueId = null)
    {
        $qb = $this->createQueryBuilder('j')
            ->where('j.disponible = : disponible')
            ->setParameter('disponible', true)
            ->orderBy('j.id', 'DESC');

        if ($marqueId) {
            $qb->andWhere('j.marque = :marqueId')
                ->setParameter('marqueId', $marqueId);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $id
     *
     * @throws NonUniqueResultException
     *
     * @return Voiture|null
     */
    public function findDisponibleVoiture(int $id): ?Voiture
    {
        return $this->createQueryBuilder('j')
            ->where('j.id = :id')
            ->andWhere('j.disponible = :disponible')
            ->setParameter('id', $id)
            ->setParameter('disponible', true)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Marque $marque
     *
     * @return AbstractQuery
     */
    public function getPaginatedDisponibleVoituresByMarqueQuery(Marque $marque): AbstractQuery
    {
        return $this->createQueryBuilder('j')
            ->where('j.marque = :marque')
            ->andWhere('j.disponible = :disponible')
            ->setParameter('marque', $marque)
            ->setParameter('disponible', true)
            ->getQuery();
    }
}
