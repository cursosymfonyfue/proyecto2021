<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\DTO;

use DateTime;

final class PostDTO
{
    const STATES = ['0' => 'disabled', '1' => 'active'];

    private int        $id;
    private string     $title;
    private string     $body;
    private ?int       $state;
    private ?\DateTime $availableAt;
    private ?string    $image;

    public function __construct()
    {
        $this->id = (int)(new \DateTime())->format('YmdHis');
        $this->title = $this->body = '';
        $this->state = $this->availableAt = $this->image = null;
    }

    public static function create(): self
    {
        return new self();
    }

    public static function createFromParams(array $params): self
    {
        $self = new self();

        $self->setId((int)$params['id']);
        $self->setTitle($params['title']);
        $self->setBody($params['body']);
        $self->setAvailableAt(new DateTime($params['available_at']));
        $self->setState((int)$params['state']);
        $self->setImage($params['image']);

        return $self;
    }

    public function getId(): int
    {
        return (int)$this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): void
    {
        $this->state = $state;
    }

    public function getAvailableAt(): ?DateTime
    {
        return $this->availableAt;
    }

    public function setAvailableAt(?DateTime $availableAt): void
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
}
