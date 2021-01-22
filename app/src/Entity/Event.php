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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

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

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;


    public function __construct()
    {
        $this->participant_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
