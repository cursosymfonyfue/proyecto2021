<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Context\Admin\Post\Form\Validator\BodyContainsAtCharacterConstraint;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    const STATES = ['active' => 1, 'disabled' => 0];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Title can not be empty")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @BodyContainsAtCharacterConstraint
     * @Assert\NotBlank(message="Body can not be empty")
     */
    private $body;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post", orphanRemoval=true)
     */
    private $comments;

    /** @ORM\Column(type="smallint", nullable=false, options={"default":0}) */
    private int $state;

    /** @ORM\Column(type="datetime", nullable=true) */
    private ?\DateTime $availableAt;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private ?string $image;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="post")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Category $category;

    /** @ORM\Column(type="smallint", nullable=false, options={"default":0}) */
    private int $likes = 0;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->availableAt = null;
        $this->image = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function setState(int $state): void
    {
        $this->state = $state;
    }

    public function getAvailableAt(): ?\DateTime
    {
        return $this->availableAt;
    }

    public function setAvailableAt(?\DateTime $availableAt): void
    {
        $this->availableAt = $availableAt;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getCategory():?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }
}
