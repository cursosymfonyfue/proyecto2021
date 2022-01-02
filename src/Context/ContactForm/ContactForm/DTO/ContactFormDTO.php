<?php declare(strict_types=1);

namespace App\Context\ContactForm\ContactForm\DTO;

final class ContactFormDTO
{
    private ?string $fullName = '';
    private ?string $subject = '';
    private ?string $body = '';

    public static function create(): self
    {
        return new self();
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): void
    {
        $this->subject = $subject;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): void
    {
        $this->body = $body;
    }
}
