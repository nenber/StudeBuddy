<?php

namespace App\Entity;

use App\Repository\FriendshipRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FriendshipRepository::class)
 */
class Friendship
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="friends", cascade={"persist", "remove"})
     */
    private $user;


    /**
     * @ORM\Column(type="boolean")
     */
    private $hasBeenHelpful;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="friendsWithMe")
     */
    public $friend;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


    public function getHasBeenHelpful(): ?bool
    {
        return $this->hasBeenHelpful;
    }

    public function setHasBeenHelpful(bool $hasBeenHelpful): self
    {
        $this->hasBeenHelpful = $hasBeenHelpful;

        return $this;
    }

    public function getFriend(): ?User
    {
        return $this->friend;
    }

    public function setFriend(?User $friend): self
    {
        $this->friend = $friend;

        return $this;
    }
}
