<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
    private $event_id;

    /**
     * @ORM\ManyToOne(targetEntity=Marker::class, inversedBy="events")
     */
    private $marker_id;

    /**
     * @ORM\ManyToOne(targetEntity=Godparent::class, inversedBy="events")
     */
    private $organizer_id;

    /**
     * @ORM\ManyToMany(targetEntity=Godson::class, inversedBy="events")
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

    public function getEventId(): ?int
    {
        return $this->event_id;
    }

    public function setEventId(?int $event_id): self
    {
        $this->event_id = $event_id;

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

    public function getOrganizerId(): ?Godparent
    {
        return $this->organizer_id;
    }

    public function setOrganizerId(?Godparent $organizer_id): self
    {
        $this->organizer_id = $organizer_id;

        return $this;
    }

    /**
     * @return Collection|Godson[]
     */
    public function getParticipantId(): Collection
    {
        return $this->participant_id;
    }

    public function addParticipantId(Godson $participantId): self
    {
        if (!$this->participant_id->contains($participantId)) {
            $this->participant_id[] = $participantId;
        }

        return $this;
    }

    public function removeParticipantId(Godson $participantId): self
    {
        if ($this->participant_id->contains($participantId)) {
            $this->participant_id->removeElement($participantId);
        }

        return $this;
    }
}
