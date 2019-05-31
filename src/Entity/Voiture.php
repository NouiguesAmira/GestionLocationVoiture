<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 * @ORM\Table(name="voitures")
 * @ORM\HasLifecycleCallbacks()
 *
 * @JMS\ExclusionPolicy("all")
 */
class Voiture
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose()
     * @JMS\Type("int")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Expose()
     * @JMS\Type("string")
     */
    private $matricule;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     * @JMS\Type("int")
     */
    private $nbPorte;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     * @JMS\Type("int")
     */
    private $nbPassager;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     * @JMS\Type("int")
     */
    private $capaciteBagage;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     * @JMS\Type("int")
     */
    private $kiloMetrage;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Expose()
     * @JMS\Type("string")
     */
    private $couleur;

    /**
     * * @var bool
     * @ORM\Column(type="boolean")
     */
    private $disponible;

    /**
     * @ORM\Column(type="float")
     * @JMS\Expose()
     * @JMS\Type("float")
     */
    public $prix;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;



    /**
     * @var Marque
     *
     * @ORM\ManyToOne(targetEntity="Marque", inversedBy="voitures")
     * @ORM\JoinColumn(name="marque_id", referencedColumnName="id", nullable=false)
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="voiture")
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNbPorte(): ?int
    {
        return $this->nbPorte;
    }

    public function setNbPorte(int $nbPorte): self
    {
        $this->nbPorte = $nbPorte;

        return $this;
    }

    public function getNbPassager(): ?int
    {
        return $this->nbPassager;
    }

    public function setNbPassager(int $nbPassager): self
    {
        $this->nbPassager = $nbPassager;

        return $this;
    }

    public function getCapaciteBagage(): ?int
    {
        return $this->capaciteBagage;
    }

    public function setCapaciteBagage(int $capaciteBagage): self
    {
        $this->capaciteBagage = $capaciteBagage;

        return $this;
    }

    public function getKiloMetrage(): ?int
    {
        return $this->kiloMetrage;
    }

    public function setKiloMetrage(int $kiloMetrage): self
    {
        $this->kiloMetrage = $kiloMetrage;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }
    /**
     * @return bool
     */
    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    /**
     * @param bool $disponible
     *
     * @return self
     */
    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }



    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null|UploadedFile
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string|null|UploadedFile $logo
     *
     * @return self
     */
    public function setLogo($logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("logo_path")
     *
     * @return string
     */
    public function getLogoPath()
    {
        return $this->getLogo() ? 'uploads/jobs/' . $this->getLogo()->getFilename() : null;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("marque_name")
     *
     * @return string
     */
    public function getMarqueName()
    {
        return $this->getMarque()->getName();
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setVoiture($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getVoiture() === $this) {
                $reservation->setVoiture(null);
            }
        }

        return $this;
    }
}
