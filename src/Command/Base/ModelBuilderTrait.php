<?php declare(strict_types=1);

namespace App\Command\Base;

use App\Context\Admin\Post\DTO\PostDTO;

trait ModelBuilderTrait
{
    private static function buildDTO(): PostDTO
    {
        $postDTO = PostDTO::create();
        $postDTO->setFechaDePublicacion(new \DateTime());
        $postDTO->setNombre('Título del post');
        $postDTO->setDescripcion('<b>Aquí vendría el mensaje del post<b><hr>aquí más info');

        return $postDTO;
    }
}
