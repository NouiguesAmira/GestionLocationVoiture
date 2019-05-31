<?php

namespace App\Service;

use App\Entity\Marque;
use Doctrine\ORM\EntityManagerInterface;

class MarqueService
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $name
     *
     * @return Marque
     */
    public function create(string $name) : Marque
    {
        $marque = new Marque();
        $marque->setName($name);

        $this->em->persist($marque);
        $this->em->flush();

        return $marque;
    }
}
