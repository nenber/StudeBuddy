<?php

namespace App\Entity;

use App\Repository\ThreadUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThreadUserRepository::class)
 */
class ThreadUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=thread::class, inversedBy="threadUsers")
     */
    private $thread_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="thread_user_id")
     */
    private $user_id;

    public function __construct()
    {
        $this->thread_id = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|thread[]
     */
    public function getThreadId(): Collection
    {
        return $this->thread_id;
    }

    public function addThreadId(thread $threadId): self
    {
        if (!$this->thread_id->contains($threadId)) {
            $this->thread_id[] = $threadId;
        }

        return $this;
    }

    public function removeThreadId(thread $threadId): self
    {
        if ($this->thread_id->contains($threadId)) {
            $this->thread_id->removeElement($threadId);
        }

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
}
