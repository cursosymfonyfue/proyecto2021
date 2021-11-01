<?php declare(strict_types=1);

namespace App\Command\Base;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;

trait ModelBuilderTrait
{
    private static function buildDTO(): PublicacionDTO
    {
        $publicacionDTO = PublicacionDTO::create();
        $publicacionDTO->setFechaDePublicacion(new \DateTime());
        $publicacionDTO->setNombre('Título del post');
        $publicacionDTO->setDescripcion('<b>Aquí vendría el mensaje del post<b><hr>aquí más info');

        return $publicacionDTO;
    }
}
