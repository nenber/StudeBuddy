<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text_body;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $created_at;

    /**
     * @ORM\Column(type="binary", nullable=true)
     */
    private $joined_file;

    /**
     * @ORM\ManyToOne(targetEntity=Thread::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $thread_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages_received")
     * @ORM\JoinColumn(nullable=false)
     */
    private $send_to;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="message_send")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextBody(): ?string
    {
        return $this->text_body;
    }

    public function setTextBody(?string $text_body): self
    {
        $this->text_body = $text_body;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getJoinedFile()
    {
        return $this->joined_file;
    }

    public function setJoinedFile($joined_file): self
    {
        $this->joined_file = $joined_file;

        return $this;
    }

    public function getThreadId(): ?Thread
    {
        return $this->thread_id;
    }

    public function setThreadId(?Thread $thread_id): self
    {
        $this->thread_id = $thread_id;

        return $this;
    }

    public function getSendTo(): ?User
    {
        return $this->send_to;
    }

    public function setSendTo(?User $send_to): self
    {
        $this->send_to = $send_to;

        return $this;
    }

    public function getSenderId(): ?User
    {
        return $this->sender_id;
    }

    public function setSenderId(?User $sender_id): self
    {
        $this->sender_id = $sender_id;

        return $this;
    }
}
