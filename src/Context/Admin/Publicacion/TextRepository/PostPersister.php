<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\TextRepository;

use App\Context\Admin\Publicacion\DTO\PostDTO;

final class PostPersister
{
    private string $kernelProjectDir;

    public function __construct(string $kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    public function persist(PostDTO $publicationDTO): void
    {
        if (!is_dir($dir = $this->kernelProjectDir . '/tmp')) {
            mkdir($dir, 0755);
        }

        if (!empty($publicationDTO->getId())) {
            $this->delete($publicationDTO->getId());
        }

        $dto = [
            'id' => $publicationDTO->getId(),
            'title' => $publicationDTO->getTitle(),
            'body' => $publicationDTO->getBody(),
            'state' => $publicationDTO->getState(),
            'available_at' => $publicationDTO->getAvailableAt()->format('Y-m-d H:i:s'),
            'image' => $publicationDTO->getImage(),
        ];

        $file = $dir . '/post.txt';
        file_put_contents($file, (is_file($file) ? PHP_EOL : '') . trim(json_encode($dto)) , FILE_APPEND);
    }

    public function delete(int $id): void
    {
        if (!is_file($path = sprintf('%s/tmp/post.txt', $this->kernelProjectDir))) {
            return;
        }

        $posts = [];

        $fp = fopen($path, "r+");
        while (($post = stream_get_line($fp, 1024 * 1024, "\n")) !== false) {
            $post = json_decode($post, true);
            if (!empty($post) && $id !== $post['id']) {
                $posts[] = json_encode($post);
            }
        }
        fclose($fp);

        file_put_contents($path, join(PHP_EOL, $posts));
    }
}
