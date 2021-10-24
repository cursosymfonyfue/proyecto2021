<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\DTO;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

final class PublicacionDTO
{
    private UuidV4     $id;
    private string     $nombre             = '';
    private string     $descripcion        = '';
    private ?int       $estado             = null;
    private ?\DateTime $fechaDePublicacion = null;
    private string     $imagen             = '';

    public function __construct()
    {
        // composer require symfony/uid
        $this->id = Uuid::v4();
    }

    public static function create(): self
    {
        return new self();
    }

    public static function createFromParams(array $params): self
    {
        $self  = new self();
        $self->setId(Uuid::fromRfc4122($params['id']));
        $self->setNombre($params['nombre']);
        $self->setDescripcion($params['descripcion']);
        $self->setFechaDePublicacion(new \DateTime($params['fecha_de_publicacion']));
        $self->setEstado(null === $params['estado']?null:(int)$params['estado']);
        $self->setImagen($params['imagen']);

        return $self;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
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
