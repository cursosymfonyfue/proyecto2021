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

        $estados = ['Activo' => 1, 'Inactivo' => 0];
        $builder->add('estado', ChoiceType::class, ['choices' => $estados]);

        $builder->add('dia_de_publicacion', TextType::class);

        $meses = MesesResolver::resolve();
        $builder->add('mes_de_publicacion', ChoiceType::class, ['choices' => $meses]);

        $anyos = [(string)($anyo = date('Y')) => $anyo, (string)(++$anyo) => $anyo];
        $builder->add('anyo_de_publicacion', ChoiceType::class, ['choices' => $anyos]);

        $builder->add('imagen', FileType::class);

        // DATA MAPPER
        $builder->setDataMapper($this->fechaDePublicacionDataMapper);

        // DATA TRANSFORMER
        $builder->get('id')->addModelTransformer($this->UUIDDataTransformer);

        // @TODO => Añadir un EVENTO para inicializar los choices y que quede todo más limpio
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublicacionDTO::class,
        ]);
    }
}
