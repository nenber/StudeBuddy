<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $organisateur_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $participant_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $marker_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $event_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrganisateurId(): ?int
    {
        return $this->organisateur_id;
    }

    public function setOrganisateurId(?int $organisateur_id): self
    {
        $this->organisateur_id = $organisateur_id;

        return $this;
    }

    public function getParticipantId(): ?int
    {
        return $this->participant_id;
    }

    public function setParticipantId(int $participant_id): self
    {
        $this->participant_id = $participant_id;

        return $this;
    }

    public function getMarkerId(): ?int
    {
        return $this->marker_id;
    }

    public function setMarkerId(?int $marker_id): self
    {
        $this->marker_id = $marker_id;

        return $this;
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
}
