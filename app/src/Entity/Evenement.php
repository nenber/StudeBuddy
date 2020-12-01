<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $event_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $evenement_id;

    /**
     * @ORM\ManyToOne(targetEntity=Marker::class, inversedBy="evenements")
     */
    private $marker_id;

    /**
     * @ORM\ManyToOne(targetEntity=Parrain::class, inversedBy="evenements")
     */
    private $organisateur_id;

    /**
     * @ORM\ManyToMany(targetEntity=Filleul::class, inversedBy="evenements")
     */
    private $participant_id;

    public function __construct()
    {
        $this->participant_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventName(): ?string
    {
        return $this->event_name;
    }

    public function setEventName(?string $event_name): self
    {
        $this->event_name = $event_name;

        return $this;
    }

    public function getEvenementId(): ?int
    {
        return $this->evenement_id;
    }

    public function setEvenementId(?int $evenement_id): self
    {
        $this->evenement_id = $evenement_id;

        return $this;
    }

    public function getMarkerId(): ?Marker
    {
        return $this->marker_id;
    }

    public function setMarkerId(?Marker $marker_id): self
    {
        $this->marker_id = $marker_id;

        return $this;
    }

    public function getOrganisateurId(): ?Parrain
    {
        return $this->organisateur_id;
    }

    public function setOrganisateurId(?Parrain $organisateur_id): self
    {
        $this->organisateur_id = $organisateur_id;

        return $this;
    }

    /**
     * @return Collection|Filleul[]
     */
    public function getParticipantId(): Collection
    {
        return $this->participant_id;
    }

    public function addParticipantId(Filleul $participantId): self
    {
        if (!$this->participant_id->contains($participantId)) {
            $this->participant_id[] = $participantId;
        }

        return $this;
    }

    public function removeParticipantId(Filleul $participantId): self
    {
        if ($this->participant_id->contains($participantId)) {
            $this->participant_id->removeElement($participantId);
        }

        return $this;
    }
}
