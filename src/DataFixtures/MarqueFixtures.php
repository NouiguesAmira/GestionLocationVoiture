<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MarqueFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager) : void
    {
        $Marque = new Marque();
        $Marque->setName('PMW');

        $Marque1 = new Marque();
        $Marque1->setName('Mercedes');

        $Marque2 = new Marque();
        $Marque2->setName('Mini Cooper');

        
        $manager->persist($Marque);
        $manager->persist($Marque1);
        $manager->persist($Marque2);
        
        $manager->flush();

        $this->addReference('marque-pmw', $Marque);
        $this->addReference('marque-mercedes', $Marque1);
        $this->addReference('marque-minicooper', $Marque2);
    }
}
