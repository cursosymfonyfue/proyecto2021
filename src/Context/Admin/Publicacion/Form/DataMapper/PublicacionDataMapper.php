<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\Form\DataMapper;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use App\Context\Application\SiteManager;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\DataMapper\DataMapper;
use Symfony\Component\Uid\Uuid;

final class PublicacionDataMapper extends DataMapper implements DataMapperInterface
{
    /** @param PublicacionDTO|null $viewData */
    public function mapDataToForms($viewData, iterable $forms): void
    {
        // there is no data yet, so nothing to prepopulate
        if (null === $viewData) {
            return;
        }

        // invalid data type
        if (!$viewData instanceof PublicacionDTO) {
            throw new \UnexpectedTypeException($viewData, \DateTime::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        // MAPEO DE FECHA DE PUBLICACIÓN
        $fechaDePublicacion = $viewData->getFechaDePublicacion();
        if (null !== $fechaDePublicacion) {
            $forms['dia_de_publicacion']->setData($fechaDePublicacion->format('d'));
            $forms['mes_de_publicacion']->setData($fechaDePublicacion->format('m'));
            $forms['anyo_de_publicacion']->setData($fechaDePublicacion->format('Y'));
        }
    }

    /** @param PublicacionDTO|null $viewData */
    public function mapFormsToData(iterable $forms, &$viewData): void
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        // MAPEO DE FECHA DE PUBLICACIÓN
        $dateAsISOString = sprintf('%s-%s-%s 00:00:00',
            $forms['anyo_de_publicacion']->getData(),
            $forms['mes_de_publicacion']->getData(),
            $forms['dia_de_publicacion']->getData()
        );
        $viewData->setFechaDePublicacion(new \DateTime($dateAsISOString));

        // MAPEO DEL NOMBRE DE LA IMAGEN - DEFINIMOS EL NOMBRE DE LA IMAGEN SI:
        // 1.- Subimos archivo
        // 2.- No se subió antes ninguna imagen
        if (null !== ($imagenFile = $forms['imagen_file']) && empty($viewData->getImagen())) {
            $name = pathinfo($imagenFile->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = $imagenFile->guessExtension();

            $imagenNombre = sprintf('%s-%s.%s',
                $name,
                Uuid::v4()->toRfc4122(),
                $ext
            );
            $viewData->setImagen($imagenNombre);
        }
    }
}
