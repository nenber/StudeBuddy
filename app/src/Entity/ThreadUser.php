<?php

namespace App\Entity;

use App\Repository\ThreadUserRepository;
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
     * @ORM\Column(type="integer")
     */
    private $thread_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThreadUserId(): ?int
    {
        return $this->thread_user_id;
    }

    public function setThreadUserId(int $thread_user_id): self
    {
        $this->thread_user_id = $thread_user_id;

        return $this;
    }

    public function getThreadId(): ?int
    {
        return $this->thread_id;
    }

    public function setThreadId(int $thread_id): self
    {
        $this->thread_id = $thread_id;

        return $this;
    }
}
