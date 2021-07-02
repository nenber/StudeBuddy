<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use http\Exception;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\EmailValidator;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @Vich\Uploadable
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas une adresse mail valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Regex("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})^/")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("^(0|(\\+33)|(0033))[1-9][0-9]{8}^", message="Numéro de téléphone invalide")
     */
    private $phone_number;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $school;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_connected;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_godparent = false;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $spoken_language = ['fr'];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $language_to_learn = ['fr'];

    /**
     * @ORM\OneToMany(targetEntity=ThreadUser::class, mappedBy="user_id")
     */
    private $thread_user_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     *
     * @Vich\UploadableField(mapping="buddy_images", fileNameProperty="imageName", size="imageSize")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int|null
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_godson = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="organizer_id")
     */
    private $organized_events;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="participant_id")
     */
    private $participated_events;

    public function __construct()
    {
        $this->thread_user_id = new ArrayCollection();
        $this->organized_events = new ArrayCollection();
        $this->participated_events = new ArrayCollection();
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

    public function getIsGodparent(): ?bool
    {
        return $this->is_godparent;
    }

    public function setIsGodparent(?bool $is_godparent): self
    {
        $this->is_godparent = $is_godparent;

        return $this;
    }

    public function getSpokenLanguage(): ?array
    {
        return $this->spoken_language;
    }

    public function setSpokenLanguage(?array $spoken_language): self
    {
        $this->spoken_language = $spoken_language;

        return $this;
    }

    public function getLanguageToLearn(): ?array
    {
        return $this->language_to_learn;
    }

    public function setLanguageToLearn(?array $language_to_learn): self
    {
        $this->language_to_learn = $language_to_learn;

        return $this;
    }

    /**
     * @return Collection|ThreadUser[]
     */
    public function getThreadUserId(): Collection
    {
        return $this->thread_user_id;
    }

    public function addThreadUserId(ThreadUser $threadUserId): self
    {
        if (!$this->thread_user_id->contains($threadUserId)) {
            $this->thread_user_id[] = $threadUserId;
            $threadUserId->setUserId($this);
        }

        return $this;
    }

    public function removeThreadUserId(ThreadUser $threadUserId): self
    {
        if ($this->thread_user_id->contains($threadUserId)) {
            $this->thread_user_id->removeElement($threadUserId);
            // set the owning side to null (unless already changed)
            if ($threadUserId->getUserId() === $this) {
                $threadUserId->setUserId(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getIsGodson(): ?bool
    {
        return $this->is_godson;
    }

    public function setIsGodson(?bool $is_godson): self
    {
        $this->is_godson = $is_godson;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getOrganizedEvents(): Collection
    {
        return $this->organized_events;
    }

    public function addOrganizedEvent(Event $organizedEvent): self
    {
        if (!$this->organized_events->contains($organizedEvent)) {
            $this->organized_events[] = $organizedEvent;
            $organizedEvent->setOrganizerId($this);
        }

        return $this;
    }

    public function removeOrganizedEvent(Event $organizedEvent): self
    {
        if ($this->organized_events->contains($organizedEvent)) {
            $this->organized_events->removeElement($organizedEvent);
            // set the owning side to null (unless already changed)
            if ($organizedEvent->getOrganizerId() === $this) {
                $organizedEvent->setOrganizerId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getParticipatedEvents(): Collection
    {
        return $this->participated_events;
    }

    public function addParticipatedEvent(Event $participatedEvent): self
    {
        if (!$this->participated_events->contains($participatedEvent)) {
            $this->participated_events[] = $participatedEvent;
            $participatedEvent->addParticipantId($this);
        }

        return $this;
    }

    public function removeParticipatedEvent(Event $participatedEvent): self
    {
        if ($this->participated_events->contains($participatedEvent)) {
            $this->participated_events->removeElement($participatedEvent);
            $participatedEvent->removeParticipantId($this);
        }

        return $this;
    }

    /**
     * @return User
     * @throws Exception
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {

        list(
            $this->id,
            $this->email,
            $this->password,
            ) = unserialize($serialized);
    }

}
