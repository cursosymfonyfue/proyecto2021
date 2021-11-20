<?php declare(strict_types=1);

namespace App\Context\ContactForm\ContactForm04\DTO;

final class ContactFormDTO
{
    private ?string $firstName = '';
    private ?string $lastName = '';

    public static function create(): self
    {
        return new self();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }
}
