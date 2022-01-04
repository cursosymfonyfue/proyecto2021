<?php declare(strict_types=1);

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ContactRepository;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
final class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="full_name")
     * @Assert\NotBlank(message="Full name can not be empty")
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Title can not be empty")
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Body can not be empty")
     */
    private $body;

    /** @ORM\Column(type="datetime", nullable=true) */
    private ?\DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body): void
    {
        $this->body = $body;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
