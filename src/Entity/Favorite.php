<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FavoriteRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FavoriteRepository::class)
 * @UniqueEntity(
 * fields={"book", "user"},
 * errorPath="book",
 * message="It appears you have already put this book in favorite."
 *)
 */
class Favorite
{
    /**
     * @Groups({"book_browse", "book_read", "favorite_browse", "favorite_read", "user_browse", "user_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"book_browse", "book_read", "favorite_browse", "favorite_read", "user_browse", "user_read"})
     * @ORM\Column(type="boolean")
     */
    private $isFavorite;

    /**
     * @Groups({"favorite_browse", "favorite_read", "user_browse", "user_read", "most_favorite"})
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="favorites")
     */
    private $book;

    /**
     * @Groups({"book_browse", "book_read", "favorite_browse", "favorite_read"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favorites")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

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
