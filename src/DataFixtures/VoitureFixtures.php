<?php
namespace App\DataFixtures;

use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class VoitureFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $voiture = new Voiture();
        $voiture->setMarque($manager->merge($this->getReference('marque-pmw')));
        $voiture->setMatricule('Xyz0001');
        $voiture->setNbPorte(4);
        $voiture->setNbPassager(4);
        $voiture->setCapaciteBagage(20);
        $voiture->setKiloMetrage(50);
        $voiture->setCouleur('Bleu');
        $voiture->setDisponible(true);
        $voiture->setPrix(70);
        $voiture->setLogo('pmw-bleu.jpg');


        $voiture1 = new Voiture();
        $voiture1->setMarque($manager->merge($this->getReference('marque-mercedes')));
        $voiture1->setMatricule('merc0001');
        $voiture1->setNbPorte(2);
        $voiture1->setNbPassager(2);
        $voiture1->setCapaciteBagage(20);
        $voiture1->setKiloMetrage(50);
        $voiture1->setCouleur('Bleu');
        $voiture1->setDisponible(true);
        $voiture1->setPrix(60);
        $voiture1->setLogo('mercedes-bleu.png');



        $manager->persist($voiture);
        $manager->persist($voiture1);

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            MarqueFixtures::class,
        ];
    }
}
