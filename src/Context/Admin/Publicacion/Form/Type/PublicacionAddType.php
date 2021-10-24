<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\Form\Type;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use App\Context\Admin\Publicacion\Form\DataMapper\FechaDePublicacionDataMapper;
use App\Context\Admin\Publicacion\Form\DataTransformer\UUIDDataTransformer;
use App\Context\Admin\Publicacion\Resolver\MesesResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PublicacionAddType extends AbstractType
{
    private FechaDePublicacionDataMapper $fechaDePublicacionDataMapper;
    private UUIDDataTransformer          $UUIDDataTransformer;

    public function __construct(FechaDePublicacionDataMapper $fechaDePublicacionDataMapper,
                                UUIDDataTransformer          $UUIDDataTransformer)
    {
        $this->fechaDePublicacionDataMapper = $fechaDePublicacionDataMapper;
        $this->UUIDDataTransformer = $UUIDDataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', HiddenType::class);
        $builder->add('titulo', TextType::class);
        $builder->add('descripcion', TextareaType::class);

        $builder->add('estado', ChoiceType::class);
        $builder->add('dia_de_publicacion', TextType::class);
        $builder->add('mes_de_publicacion', ChoiceType::class);
        $builder->add('anyo_de_publicacion', ChoiceType::class);

        $builder->add('imagen', FileType::class);

        // DATA MAPPER
        $builder->setDataMapper($this->fechaDePublicacionDataMapper);

        // DATA TRANSFORMER
        $builder->get('id')->addModelTransformer($this->UUIDDataTransformer);

        // FORM EVENTS
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();

        // Add años
        $options = $form->get('anyo_de_publicacion')->getConfig()->getOptions();
        $anyos = [(string)($anyo = date('Y')) => $anyo, (string)(++$anyo) => $anyo];
        $options['choices'] = $anyos;
        $form->add('anyo_de_publicacion', ChoiceType::class, $options);

        // Add meses
        $options = $form->get('mes_de_publicacion')->getConfig()->getOptions();
        $meses = MesesResolver::resolve();
        $options['choices'] = $meses;
        $form->add('mes_de_publicacion', ChoiceType::class, $options);

        // Add estado
        $options = $form->get('estado')->getConfig()->getOptions();
        $estados = ['Activo' => 1, 'Inactivo' => 0];
        $options['choices'] = $estados;
        $form->add('estado', ChoiceType::class, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublicacionDTO::class,
        ]);
    }
}
