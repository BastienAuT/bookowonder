<?php

namespace App\Entity;

use App\Repository\RecommendationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RecommendationRepository::class)
 * @UniqueEntity(
 * fields={"recommendation", "book", "user"},
 * errorPath="book",
 * message="It appears you have already recommendate this book."
 *)
 */
class Recommendation
{
    /**
     * @Groups({"book_read", "recommendation_browse", "recommendation_read", "user_browse", "user_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"book_read", "recommendation_browse", "recommendation_read", "user_browse", "user_read"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @Groups({"book_read", "recommendation_browse", "recommendation_read", "user_browse", "user_read"})
     * @ORM\Column(type="boolean")
     */
    private $recommendation;

    /**
     * @Groups({"recommendation_browse", "recommendation_read", "user_browse", "user_read", "most_recommendated"})
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="recommendations")
     */
    private $book;

    /**
     * @Groups({"book_read", "recommendation_browse", "recommendation_read"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="recommendations")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    public function __construct(){
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRecommendation(): ?bool
    {
        return $this->recommendation;
    }

    public function setRecommendation(bool $recommendation): self
    {
        $this->recommendation = $recommendation;

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

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
