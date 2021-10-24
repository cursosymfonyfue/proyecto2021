<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\Form\DataMapper;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use App\Context\Application\SiteManager;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\DataMapper\DataMapper;

final class FechaDePublicacionDataMapper extends DataMapper implements DataMapperInterface
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

        $fechaDePublicacion = $viewData->getFechaDePublicacion();
        if (null === $fechaDePublicacion) {
            return;
        }

        // initialize form field values
        $forms['dia_de_publicacion']->setData($fechaDePublicacion->format('d'));
        $forms['mes_de_publicacion']->setData($fechaDePublicacion->format('m'));
        $forms['anyo_de_publicacion']->setData($fechaDePublicacion->format('Y'));
    }

    /** @param PublicacionDTO|null $viewData */
    public function mapFormsToData(iterable $forms, &$viewData): void
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $dateAsISOString = sprintf('%s-%s-%s 00:00:00',
            $forms['anyo_de_publicacion']->getData(),
            $forms['mes_de_publicacion']->getData(),
            $forms['dia_de_publicacion']->getData()
        );

        $viewData->setFechaDePublicacion(new \DateTime($dateAsISOString));
    }
}
