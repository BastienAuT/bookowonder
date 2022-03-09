<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PinnedpageRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PinnedpageRepository::class)
 * @UniqueEntity(
 * fields={"page", "book", "user"},
 * errorPath="page",
 * message="It appears you have already pinned this page."
 *)
 */
class Pinnedpage
{
    /**
     * @Groups({"book_browse", "pinnedpage_browse", "pinnedpage_read", "user_browse", "user_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"book_browse", "pinnedpage_browse", "pinnedpage_read", "user_browse", "user_read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $page;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @Groups({"pinnedpage_browse", "pinnedpage_read", "user_browse", "user_read", "most_pinned"})
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="pinnedpages")
     */
    private $book;

    /**
     * @Groups({"pinnedpage_browse", "pinnedpage_read"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pinnedpages")
     */
    private $user;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    public function setPage(?string $page): self
    {
        $this->page = $page;

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

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
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
}
