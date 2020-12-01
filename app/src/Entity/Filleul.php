<?php

namespace App\Entity;

use App\Repository\FilleulRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilleulRepository::class)
 */
class Filleul
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Parrain::class, inversedBy="filleul")
     */
    private $parrain_id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=Parrain::class, inversedBy="fillieul_id")
     */
    private $parrain;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParrainId(): ?Parrain
    {
        return $this->parrain_id;
    }

    public function setParrainId(?Parrain $parrain_id): self
    {
        $this->parrain_id = $parrain_id;

        return $this;
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

    public function getParrain(): ?Parrain
    {
        return $this->parrain;
    }

    public function setParrain(?Parrain $parrain): self
    {
        $this->parrain = $parrain;

        return $this;
    }
}
