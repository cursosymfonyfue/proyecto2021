<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\Repository;

final class PublicacionesFinder
{
    private string $kernelProjectDir;

    public function __construct(string $kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    public function findAll(): array
    {
        $path = sprintf('%s/tmp/publicacion.txt', $this->kernelProjectDir);
        if (!is_file($path)) {
            return [];
        }

        $publicaciones = [];

        $fp = fopen($path, "r+");
        while (($publicacion = stream_get_line($fp, 1024 * 1024, "\n")) !== false) {
            if (!empty($publicacion)) {
                $publicaciones[] = json_decode($publicacion, true);
            }
        }
        fclose($fp);
        return $publicaciones;
    }

    public function findById(string $id): array
    {
        if (!is_file($path = sprintf('%s/tmp/publicacion.txt', $this->kernelProjectDir))) {
            return [];
        }

        $fp = fopen($path, "r+");
        while (($publicacion = stream_get_line($fp, 1024 * 1024, "\n")) !== false) {
            $publicacion = json_decode($publicacion, true);
            if (!empty($publicacion) && $id !== $publicacion['id']) {
                return $publicacion;
            }
        }
        fclose($fp);

        return [];
    }
}
