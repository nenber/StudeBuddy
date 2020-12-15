<?php

namespace App\Entity;

use App\Repository\GodparentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GodparentRepository::class)
 */
class Godparent
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
     * @ORM\OneToMany(targetEntity=Godson::class, mappedBy="godparent_id")
     */
    private $godson_id;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="organizer_id")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity=Godson::class)
     */
    private $godsons;

    public function __construct()
    {
        $this->godson_id = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->godsons = new ArrayCollection();
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
     * @return Collection|Godson[]
     */
    public function getGodsonId(): Collection
    {
        return $this->godson_id;
    }

    public function addGodsonId(godson $godsonId): self
    {
        if (!$this->godson_id->contains($godsonId)) {
            $this->godson_id[] = $godsonId;
            $godsonId->setGodparentId($this);
        }

        return $this;
    }

    public function removeGodsonId(Godson $godsonId): self
    {
        if ($this->godson_id->contains($godsonId)) {
            $this->godson_id->removeElement($godsonId);
            // set the owning side to null (unless already changed)
            if ($godsonId->getGodparentId() === $this) {
                $godsonId->setGodparentId(null);
            }
        }

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
            $event->setOrganizerId($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getOrganizerId() === $this) {
                $event->setOrganizerId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Godson[]
     */
    public function getGodsons(): Collection
    {
        return $this->godsons;
    }

    public function addGodson(Godson $godson): self
    {
        if (!$this->godsons->contains($godson)) {
            $this->godsons[] = $godson;
        }

        return $this;
    }

    public function removeGodson(Godson $godson): self
    {
        if ($this->godsons->contains($godson)) {
            $this->godsons->removeElement($godson);
        }

        return $this;
    }
}
