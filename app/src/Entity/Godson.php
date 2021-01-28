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
     * @ORM\ManyToMany(targetEntity=Godparent::class, inversedBy="godson_id")
     */
    private $godparent_id;


    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->godparent_id = new ArrayCollection();
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
     * @return Collection|Godparent[]
     */
    public function getGodparentId(): Collection
    {
        return $this->godparent_id;
    }

    public function addGodparentId(Godparent $godparentId): self
    {
        if (!$this->godparent_id->contains($godparentId)) {
            $this->godparent_id[] = $godparentId;
        }

        return $this;
    }

    public function removeGodparentId(Godparent $godparentId): self
    {
        if ($this->godparent_id->contains($godparentId)) {
            $this->godparent_id->removeElement($godparentId);
        }

        return $this;
    }
}
