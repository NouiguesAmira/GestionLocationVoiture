<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    public $dateDebutReservation;

    /**
     * @ORM\Column(type="integer")
     */
    public $nbJours;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Voiture", inversedBy="reservations")
     */
    private $voiture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="Reservations")
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutReservation(): ?\DateTimeInterface
    {
        return $this->dateDebutReservation;
    }

    public function setDateDebutReservation(\DateTimeInterface $dateDebutReservation): self
    {
        $this->dateDebutReservation = $dateDebutReservation;

        return $this;
    }

    public function getNbJours(): ?int
    {
        return $this->nbJours;
    }

    public function setNbJours(int $nbJours): self
    {
        $this->nbJours = $nbJours;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
