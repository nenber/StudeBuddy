<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $school;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_connected;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_parrain;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $spoken_language;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $language_to_learn;

    /**
     * @ORM\OneToMany(targetEntity=ThreadUser::class, mappedBy="thread_user_id")
     */
    private $threadUsers;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="send_to")
     */
    private $messages_received;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="sender_id")
     */
    private $message_send;

    public function __construct()
    {
        $this->threadUsers = new ArrayCollection();
        $this->messages_received = new ArrayCollection();
        $this->message_send = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getSchool(): ?string
    {
        return $this->school;
    }

    public function setSchool(string $school): self
    {
        $this->school = $school;

        return $this;
    }

    public function getIsConnected(): ?bool
    {
        return $this->is_connected;
    }

    public function setIsConnected(bool $is_connected): self
    {
        $this->is_connected = $is_connected;

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

    public function getIsParrain(): ?bool
    {
        return $this->is_parrain;
    }

    public function setIsParrain(?bool $is_parrain): self
    {
        $this->is_parrain = $is_parrain;

        return $this;
    }

    public function getSpokenLanguage(): ?string
    {
        return $this->spoken_language;
    }

    public function setSpokenLanguage(string $spoken_language): self
    {
        $this->spoken_language = $spoken_language;

        return $this;
    }

    public function getLanguageToLearn(): ?string
    {
        return $this->language_to_learn;
    }

    public function setLanguageToLearn(?string $language_to_learn): self
    {
        $this->language_to_learn = $language_to_learn;

        return $this;
    }

    /**
     * @return Collection|ThreadUser[]
     */
    public function getThreadUsers(): Collection
    {
        return $this->threadUsers;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessagesReceived(): Collection
    {
        return $this->messages_received;
    }

    public function addMessagesReceived(Message $messagesReceived): self
    {
        if (!$this->messages_received->contains($messagesReceived)) {
            $this->messages_received[] = $messagesReceived;
            $messagesReceived->setSendTo($this);
        }

        return $this;
    }

    public function removeMessagesReceived(Message $messagesReceived): self
    {
        if ($this->messages_received->contains($messagesReceived)) {
            $this->messages_received->removeElement($messagesReceived);
            // set the owning side to null (unless already changed)
            if ($messagesReceived->getSendTo() === $this) {
                $messagesReceived->setSendTo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessageSend(): Collection
    {
        return $this->message_send;
    }

    public function addMessageSend(Message $messageSend): self
    {
        if (!$this->message_send->contains($messageSend)) {
            $this->message_send[] = $messageSend;
            $messageSend->setSenderId($this);
        }

        return $this;
    }

    public function removeMessageSend(Message $messageSend): self
    {
        if ($this->message_send->contains($messageSend)) {
            $this->message_send->removeElement($messageSend);
            // set the owning side to null (unless already changed)
            if ($messageSend->getSenderId() === $this) {
                $messageSend->setSenderId(null);
            }
        }

        return $this;
    }
}
