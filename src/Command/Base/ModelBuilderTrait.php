<?php declare(strict_types=1);

namespace App\Command\Base;

use App\Context\Admin\Post\DTO\PostDTO;

trait ModelBuilderTrait
{
    private static function buildDTO(): PostDTO
    {
        $postDTO = PostDTO::create();
        $postDTO->setAvailableAt(new \DateTime());
        $postDTO->setTitle('Título del post');
        $postDTO->setBody('<b>Aquí vendría el mensaje del post</b>. Aquí más info...');

        return $postDTO;
    }
}
