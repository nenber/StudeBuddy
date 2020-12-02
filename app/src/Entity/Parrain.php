<?php

namespace App\Entity;

use App\Repository\ParrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParrainRepository::class)
 */
class Parrain
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
     * @ORM\OneToMany(targetEntity=Filleul::class, mappedBy="parrain_id")
     */
    private $fillieul_id;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="organisateur_id")
     */
    private $evenements;

    public function __construct()
    {
        $this->fillieul_id = new ArrayCollection();
        $this->evenements = new ArrayCollection();
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
     * @return Collection|Filleul[]
     */
    public function getFillieulId(): Collection
    {
        return $this->fillieul_id;
    }

    public function addFillieulId(Filleul $fillieulId): self
    {
        if (!$this->fillieul_id->contains($fillieulId)) {
            $this->fillieul_id[] = $fillieulId;
            $fillieulId->setParrainId($this);
        }

        return $this;
    }

    public function removeFillieulId(Filleul $fillieulId): self
    {
        if ($this->fillieul_id->contains($fillieulId)) {
            $this->fillieul_id->removeElement($fillieulId);
            // set the owning side to null (unless already changed)
            if ($fillieulId->getParrainId() === $this) {
                $fillieulId->setParrainId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setOrganisateurId($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getOrganisateurId() === $this) {
                $evenement->setOrganisateurId(null);
            }
        }

        return $this;
    }
}
