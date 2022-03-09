<?php

namespace App\Entity;

use App\Entity\Pinnedpage;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @Groups({"book_browse", "book_read", "favorite_browse", "favorite_read", "pinnedpage_browse", "pinnedpage_read", "recommendation_browse", "recommendation_read", "user_browse", "user_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"book_browse", "book_read", "favorite_browse", "favorite_read", "pinnedpage_browse", "pinnedpage_read", "recommendation_browse", "recommendation_read", "user_browse", "user_read"})
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @Groups({"user_read"})
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups({"book_browse", "book_read", "pinnedpage_browse", "pinnedpage_read", "recommendation_browse", "recommendation_read", "user_browse", "user_read"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"user_browse", "user_read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profilePic;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @Groups({"user_browse", "user_read"})
     * @ORM\OneToMany(targetEntity=Recommendation::class, mappedBy="user")
     */
    private $recommendations;

    /**
     * @Groups({"user_browse", "user_read"})
     * @ORM\OneToMany(targetEntity=Pinnedpage::class, mappedBy="user")
     */
    private $pinnedpages;

    /**
     * @Groups({"user_browse", "user_read"})
     * @ORM\OneToMany(targetEntity=Favorite::class, mappedBy="user")
     */
    private $favorites;

    public function __construct()
    {
        $this->profilePic = "user_default.png";
        $this->recommendations = new ArrayCollection();
        $this->pinnedpages = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->favorites = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProfilePic(): ?string
    {
        return $this->profilePic;
    }

    public function setProfilePic(?string $profilePic): self
    {
        $this->profilePic = $profilePic;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Recommendation[]
     */
    public function getRecommendations(): Collection
    {
        return $this->recommendations;
    }

    public function addRecommendation(Recommendation $recommendation): self
    {
        if (!$this->recommendations->contains($recommendation)) {
            $this->recommendations[] = $recommendation;
            $recommendation->setUser($this);
        }

        return $this;
    }

    public function removeRecommendation(Recommendation $recommendation): self
    {
        if ($this->recommendations->removeElement($recommendation)) {
            // set the owning side to null (unless already changed)
            if ($recommendation->getUser() === $this) {
                $recommendation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pinnedpage[]
     */
    public function getPinnedpages(): Collection
    {
        return $this->pinnedpages;
    }

    public function addPinnedpage(Pinnedpage $pinnedpage): self
    {
        if (!$this->pinnedpages->contains($pinnedpage)) {
            $this->pinnedpages[] = $pinnedpage;
            $pinnedpage->setUser($this);
        }

        return $this;
    }

    public function removePinnedpage(Pinnedpage $pinnedpage): self
    {
        if ($this->pinnedpages->removeElement($pinnedpage)) {
            // set the owning side to null (unless already changed)
            if ($pinnedpage->getUser() === $this) {
                $pinnedpage->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Favorite[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setUser($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }

        return $this;
    }
}
