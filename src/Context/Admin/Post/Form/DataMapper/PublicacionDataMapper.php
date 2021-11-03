<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Form\DataMapper;

use App\Context\Admin\Post\DTO\PostDTO;
use Exception;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\DataMapper\DataMapper;

final class PublicacionDataMapper extends DataMapper implements DataMapperInterface
{
    /** @param PostDTO|null $viewData */
    public function mapDataToForms($viewData, iterable $forms): void
    {
        // there is no data yet, so nothing to prepopulate
        if (null === $viewData) {
            return;
        }

        // invalid data type
        if (!$viewData instanceof PostDTO) {
            throw new Exception('expected PostDTO type object');
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        // Esta línea es importante que vaya inmediatamente después de iterator_to_array
        parent::mapDataToForms($viewData, $forms);

        // MAPEO DE FECHA DE PUBLICACIÓN
        $availableAt = $viewData->getAvailableAt();
        if (null !== $availableAt) {
            $forms['availability_day']->setData($availableAt->format('d'));
            $forms['availability_month']->setData($availableAt->format('m'));
            $forms['availability_year']->setData($availableAt->format('Y'));
        }
    }

    /** @param PostDTO|null $viewData */
    public function mapFormsToData(iterable $forms, &$viewData): void
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        // MAPEO DE FECHA DE PUBLICACIÓN
        $dateAsISOString = sprintf('%s-%s-%s 00:00:00',
            $forms['availability_year']->getData(),
            $forms['availability_month']->getData(),
            $forms['availability_day']->getData()
        );
        $viewData->setAvailableAt(new \DateTime($dateAsISOString));

        // MAPEO DEL NOMBRE DE LA IMAGEN - DEFINIMOS EL NOMBRE DE LA IMAGEN SI:
        // 1.- Subimos archivo
        // 2.- No se subió antes ninguna imagen
        if (null !== ($imagenFile = $forms['image_file']->getData())) {
            $name = pathinfo($imagenFile->getData()->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = $imagenFile->guessExtension();

            $imageName = sprintf('%s-%s.%s',
                $name,
                $viewData->getId(),
                $ext
            );
            $viewData->setImage($imageName);
        }

        // Esta línea es importante para que sean efectivos los cambios
        parent::mapFormsToData($forms, $viewData);
    }
}
