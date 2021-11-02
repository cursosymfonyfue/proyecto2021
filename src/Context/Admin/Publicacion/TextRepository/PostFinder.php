<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\TextRepository;

final class PostFinder
{
    private string $kernelProjectDir;

    public function __construct(string $kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    public function findAll(): array
    {
        $path = sprintf('%s/tmp/post.txt', $this->kernelProjectDir);
        if (!is_file($path)) {
            return [];
        }

        $posts = [];

        $fp = fopen($path, "r+");
        while (($post = stream_get_line($fp, 1024 * 1024, "\n")) !== false) {
            if (!empty($post)) {
                $posts[] = json_decode($post, true);
            }
        }
        fclose($fp);
        return $posts;
    }

    public function findById(int $id): array
    {
        if (!is_file($path = sprintf('%s/tmp/post.txt', $this->kernelProjectDir))) {
            return [];
        }

        $fp = fopen($path, "r+");
        while (($post = stream_get_line($fp, 1024 * 1024, "\n")) !== false) {
            $post = json_decode($post, true);

            if (!empty($post) && (int)$id === (int)$post['id']) {
                fclose($fp);
                return $post;
            }
        }

        fclose($fp);
        return [];
    }
}
