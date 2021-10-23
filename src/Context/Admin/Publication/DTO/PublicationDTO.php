<?php declare(strict_types=1);

namespace App\Context\Admin\Publication\DTO;

final class PublicationDTO
{
    private string $id;
    private string $nombre  = '';
    private string $descripcion  = '';
    private ?int $estado = null;
    private ?\DateTime $fechaDePublicacion = null;
    private string $imagen = '';

    public static function create(): self
    {
        return new self();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getEstado(): ?int
    {
        return $this->estado;
    }

    public function setEstado(?int $estado): void
    {
        $this->estado = $estado;
    }

    public function getFechaDePublicacion(): ?\DateTime
    {
        return $this->fechaDePublicacion;
    }

    public function setFechaDePublicacion(?\DateTime $fechaDePublicacion): void
    {
        $this->fechaDePublicacion = $fechaDePublicacion;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }
}
