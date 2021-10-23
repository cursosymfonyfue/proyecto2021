<?php declare(strict_types=1);

namespace App\Context\Frontend\ContactForm\Form\DataMapper;

use App\Context\Application\SiteManager;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\DataMapper\DataMapper;

final class FechaDePublicacionDataMapper extends DataMapper implements DataMapperInterface
{
    /**
     * @param \DateTime|null $viewData
     */
    public function mapDataToForms($viewData, \Traversable $forms): void
    {
        // there is no data yet, so nothing to prepopulate
        if (null === $viewData) {
            return;
        }

        // invalid data type
        if (!$viewData instanceof \DateTime) {
            throw new UnexpectedTypeException($viewData, \DateTime::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        // initialize form field values
        $forms['dia_de_publicacion']->setData($viewData->format('d'));
        $forms['mes_de_publicacion']->setData($viewData->format('m'));
        $forms['ano_de_publicacion']->setData($viewData->format('Y'));
    }

    public function mapFormsToData(\Traversable $forms, &$viewData): void
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $dateAsISOString = sprintf('%s-%s-%s',
            $forms['ano_de_publicacion']->getData(),
            $forms['mes_de_publicacion']->getData(),
            $forms['dia_de_publicacion']->getData()
        );
        $viewData = new \DateTime($dateAsISOString);
    }
}
