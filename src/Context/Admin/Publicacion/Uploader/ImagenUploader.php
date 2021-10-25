<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\Uploader;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class ImagenUploader
{
    private string $kernelProjectDir;

    public function __construct(string $kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    public function upload(?UploadedFile $imagen, PublicacionDTO $publicacionDTO): void
    {
        if (null === $imagen) {
            return;
        }
        // $originalFilename = pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME);

        $destination = $this->resolveUploadPath();
        $newFilename = $publicacionDTO->getId() . '.' . $imagen->guessExtension();
        $imagen->move($destination, $newFilename);
    }

    private function resolveUploadPath(): string
    {
        $destination = $this->kernelProjectDir . '/public/uploads';
        if (!is_dir($destination)) {
            mkdir($destination, 0755);
        }

        return $destination;
    }
}
