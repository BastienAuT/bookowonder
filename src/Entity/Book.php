<?php

namespace App\Entity;




use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @Groups({"book_browse", "book_read", "author_browse", "author_read", "category_read", "editor_browse", "editor_read", "favorite_browse", "favorite_read", "pinnedpage_browse", "pinnedpage_read", "recommendation_browse", "recommendation_read", "user_browse", "user_read", "most_favorite", "most_recommendated", "most_pinned"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"book_browse", "book_read", "author_browse", "author_read", "category_read", "editor_browse", "editor_read", "favorite_browse", "favorite_read", "pinnedpage_browse", "pinnedpage_read", "recommendation_browse", "recommendation_read", "user_browse", "user_read", "most_favorite", "most_recommendated", "most_pinned"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Groups({"book_browse", "book_read"})
     * @ORM\Column(type="text")
     */
    private $synopsis;

    /**
     * @Groups({"book_browse", "book_read", "category_read", "recommendation_browse", "recommendation_read", "favorite_browse", "favorite_read", "user_browse", "user_read", "pinnedpage_read", "most_favorite", "most_recommendated", "most_pinned"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @Groups({"book_browse", "book_read", "user_read", "pinnedpage_read"})
     * @ORM\Column(type="string", length=255)
     */
    private $epub;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $isbn;

    /**
     * @Groups({"book_browse", "book_read"})
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $publishedAt;

    /**
     * @Groups({"book_browse", "book_read"})
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @Groups({"book_browse", "book_read"})
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @Groups({"book_browse", "book_read"})
     * @ORM\Column(type="boolean")
     */
    private $isHome;

    /**
     * @Groups({"book_browse", "book_read", "category_read"})
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     */
    private $author;

    /**
     * @Groups({"book_browse", "book_read", "category_read"})
     * @ORM\ManyToOne(targetEntity=Editor::class, inversedBy="books")
     */
    private $editor;

    /**
     * @Groups({"book_browse", "book_read"})
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="books")
     */
    private $categories;

    /**
     * @Groups({"book_read"})
     * @ORM\OneToMany(targetEntity=Recommendation::class, mappedBy="book")
     */
    private $recommendations;

    /**
     * @Groups({"book_browse", "book_read"})
     * @ORM\OneToMany(targetEntity=Pinnedpage::class, mappedBy="book")
     */
    private $pinnedpages;

    /**
     * @Groups({"book_browse", "book_read"})
     * @ORM\OneToMany(targetEntity=Favorite::class, mappedBy="book")
     */
    private $favorites;

    /**
     * @Groups({"book_browse", "book_read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $frontPic;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->recommendations = new ArrayCollection();
        $this->pinnedpages = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->favorites = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getEpub(): ?string
    {
        return $this->epub;
    }

    public function setEpub(string $epub): self
    {
        $this->epub = $epub;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

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

    public function getIsHome(): ?bool
    {
        return $this->isHome;
    }

    public function setIsHome(bool $isHome): self
    {
        $this->isHome = $isHome;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

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
            $recommendation->setBook($this);
        }

        return $this;
    }

    public function removeRecommendation(Recommendation $recommendation): self
    {
        if ($this->recommendations->removeElement($recommendation)) {
            // set the owning side to null (unless already changed)
            if ($recommendation->getBook() === $this) {
                $recommendation->setBook(null);
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
            $pinnedpage->setBook($this);
        }

        return $this;
    }

    public function removePinnedpage(Pinnedpage $pinnedpage): self
    {
        if ($this->pinnedpages->removeElement($pinnedpage)) {
            // set the owning side to null (unless already changed)
            if ($pinnedpage->getBook() === $this) {
                $pinnedpage->setBook(null);
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
            $favorite->setBook($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getBook() === $this) {
                $favorite->setBook(null);
            }
        }

        return $this;
    }

    public function getFrontPic(): ?string
    {
        return $this->frontPic;
    }

    public function setFrontPic(?string $frontPic): self
    {
        $this->frontPic = $frontPic;

        return $this;
    }
}
