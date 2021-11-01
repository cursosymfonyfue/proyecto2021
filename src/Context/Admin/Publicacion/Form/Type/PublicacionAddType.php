<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\Form\Type;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use App\Context\Admin\Publicacion\Form\DataMapper\PublicacionDataMapper;
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

class PublicacionAddType extends AbstractType
{
    private PublicacionDataMapper $publicacionDataMapper;
    private UUIDDataTransformer   $UUIDDataTransformer;

    public function __construct(PublicacionDataMapper $publicacionDataMapper,
                                UUIDDataTransformer   $UUIDDataTransformer)
    {
        $this->publicacionDataMapper = $publicacionDataMapper;
        $this->UUIDDataTransformer = $UUIDDataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', HiddenType::class);

        // Es recomendable que todo lo referente a UX esté en el propio html
        $builder->add('titulo', TextType::class, [
            'attr' => [
                'placeholder' => 'inserte aquí un título',
            ],
            'help' => '<span class="fa fa-info-circle mt-2"> escoja un título que resuma la publicación</span>',
            'help_html' => true,
        ]);

        $builder->add('descripcion', TextareaType::class);

        // Ver línea 370 Symfony\Component\Form\Extension\Core\Type\ChoiceType para ver los parámetros admitidos
        $estados = ['Activo' => 1, 'Inactivo' => 0];
        $builder->add('estado', ChoiceType::class, ['choices' => $estados]);

        $builder->add('dia_de_publicacion', TextType::class);
        $builder->add('mes_de_publicacion', ChoiceType::class);
        $builder->add('anyo_de_publicacion', ChoiceType::class);

        $builder->add('imagen', HiddenType::class);
        $builder->add('imagen_file', FileType::class, ['mapped' => false]);

        // DATA MAPPER
        $builder->setDataMapper($this->publicacionDataMapper);

        // DATA TRANSFORMER
        $builder->get('id')->addModelTransformer($this->UUIDDataTransformer);

        // LOS 5 FORM EVENTS
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
        $builder->addEventListener(FormEvents::POST_SET_DATA, function () {
            echo "estoy en post-set-data <br>";
        });
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function () {
            echo "estoy en pre-submit <br>";
        });
        $builder->addEventListener(FormEvents::SUBMIT, function () {
            echo "estoy en submit <br>";
        });
        $builder->addEventListener(FormEvents::POST_SUBMIT, function () {
            echo "estoy en post-submit <br>";
        });
    }

    public function onPreSetData(FormEvent $event)
    {
        echo "estoy en pre-set-data <br>";

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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublicacionDTO::class,
        ]);
    }
}
