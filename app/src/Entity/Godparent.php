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
     * @ORM\ManyToMany(targetEntity=Godson::class, mappedBy="godparent_id")
     */
    private $godson_id;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->godson_id = new ArrayCollection();
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

    public function addGodsonId(Godson $godsonId): self
    {
        if (!$this->godson_id->contains($godsonId)) {
            $this->godson_id[] = $godsonId;
            $godsonId->addGodparentId($this);
        }

        return $this;
    }

    public function removeGodsonId(Godson $godsonId): self
    {
        if ($this->godson_id->contains($godsonId)) {
            $this->godson_id->removeElement($godsonId);
            $godsonId->removeGodparentId($this);
        }

        return $this;
    }
}
