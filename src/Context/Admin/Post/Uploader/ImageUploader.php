<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Uploader;

use App\Context\Admin\Post\DTO\PostDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class ImageUploader
{
    private string $kernelProjectDir;

    public function __construct(string $kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    public function upload(?UploadedFile $imagen, PostDTO $postDTO): void
    {
        if (null === $imagen) {
            return;
        }

        $imagen->move($this->resolveUploadPath(), $postDTO->getImage());
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
