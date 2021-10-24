<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\Repository;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;

final class PublicacionesPersister
{
    private string $kernelProjectDir;

    public function __construct(string $kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    public function persist(PublicacionDTO $publicationDTO): void
    {
        if (!is_dir($dir = $this->kernelProjectDir . '/tmp')) {
            mkdir($dir, 0755);
        }

        $dto = [
            'id' => $publicationDTO->getId(),
            'nombre' => $publicationDTO->getNombre(),
            'descripcion' => $publicationDTO->getDescripcion(),
            'estado' => $publicationDTO->getEstado(),
            'fecha_de_publicacion' => $publicationDTO->getFechaDePublicacion()->format('Y-m-d H:i:s'),
            'imagen' => $publicationDTO->getImagen(),
        ];

        file_put_contents($dir . '/publicacion.txt', json_encode($dto) . PHP_EOL, FILE_APPEND);
    }

    public function delete(string $id): void
    {
        if (!is_file($path = sprintf('%s/tmp/publicacion.txt', $this->kernelProjectDir))) {
            return;
        }

        $fp = fopen($path, "r+");
        while (($publicacion = stream_get_line($fp, 1024 * 1024, "\n")) !== false) {
            $publicacion = json_decode($publicacion, true);
            if (!empty($publicacion) && $id !== $publicacion['id']) {
                $publicaciones[] = json_encode($publicacion);
            }
        }
        fclose($fp);

        file_put_contents($path, join(PHP_EOL, $publicaciones));
    }
}
