<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarqueRepository")
 * @ORM\Table(name="marques")
 */
class Marque
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     *
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $slug;

    /**
     * @var Voiture[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Voiture", mappedBy="marque", cascade={"remove"})
     */
    private $voitures;


    public function __construct()
    {
        $this->voitures = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug() : ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return Voiture[]|ArrayCollection
     */
    public function getVoitures()
    {
        return $this->voitures;
    }

    /**
     * @return Voiture[]|ArrayCollection
     */
    public function getActiveVoitures()
    {
        return $this->voitures;
    }

    /**
     * @param Voiture $voiture
     *
     * @return self
     */
    public function addVoiture(Voiture $voiture) : self
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures->add($voiture);
        }

        return $this;
    }

    /**
     * @param Voiture $voiture
     *
     * @return self
     */
    public function removeVoiture(Voiture $voiture) : self
    {
        $this->voitures->removeElement($voiture);

        return $this;
    }

}
