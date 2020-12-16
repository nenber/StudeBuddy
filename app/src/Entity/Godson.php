<?php

namespace App\Entity;

use App\Repository\GodsonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GodsonRepository::class)
 */
class Godson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user_id;


    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="participant_id")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity=Godparent::class)
     */
    private $godparents;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->godparents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addParticipantId($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeParticipantId($this);
        }

        return $this;
    }

    /**
     * @return Collection|Godparent[]
     */
    public function getGodparents(): Collection
    {
        return $this->godparents;
    }

    public function addGodparent(Godparent $godparent): self
    {
        if (!$this->godparents->contains($godparent)) {
            $this->godparents[] = $godparent;
        }

        return $this;
    }

    public function removeGodparent(Godparent $godparent): self
    {
        if ($this->godparents->contains($godparent)) {
            $this->godparents->removeElement($godparent);
        }

        return $this;
    }
}
