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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parrain_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParrainId(): ?int
    {
        return $this->parrain_id;
    }

    public function setParrainId(?int $parrain_id): self
    {
        $this->parrain_id = $parrain_id;

        return $this;
    }
}
