<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @Groups({"book_browse", "book_read", "audio_browse", "audio_read", "category_browse", "category_read", "most_read_category", "category_readAudio"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"book_browse", "book_read", "audio_browse", "audio_read", "category_browse", "category_read", "most_read_category", "category_readAudio"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @Groups({"category_read"})
     * @ORM\ManyToMany(targetEntity=Book::class, mappedBy="categories")
     */
    private $books;

    /**
     * @Groups({"category_read", "category_readAudio"})
     * @ORM\ManyToMany(targetEntity=Audio::class, mappedBy="categories")
     */
    private $audio;

    /**
     * @Groups({"book_browse", "book_read", "audio_browse", "audio_read", "category_browse", "category_read", "most_read_category", "category_readAudio"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->audio = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->addCategory($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            $book->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection|Audio[]
     */
    public function getAudio(): Collection
    {
        return $this->audio;
    }

    public function addAudio(Audio $audio): self
    {
        if (!$this->audio->contains($audio)) {
            $this->audio[] = $audio;
            $audio->addCategory($this);
        }

        return $this;
    }

    public function removeAudio(Audio $audio): self
    {
        if ($this->audio->removeElement($audio)) {
            $audio->removeCategory($this);
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
