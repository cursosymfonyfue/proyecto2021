<?php declare(strict_types=1);

namespace App\Context\Admin\Publication;

use App\Context\Frontend\ContactForm\Form\DataMapper\FechaDePublicacionDataMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class PublicationAddType extends AbstractType
{
    private FechaDePublicacionDataMapper $fechaDePublicacionDataMapper;

    public function __construct(FechaDePublicacionDataMapper $fechaDePublicacionDataMapper)
    {
        $this->fechaDePublicacionDataMapper = $fechaDePublicacionDataMapper;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titulo', TextType::class);
        $builder->add('descripcion', TextareaType::class);

        $builder->add('estado', ChoiceType::class, ['data']);
        $builder->add('dia_de_publicacion', TextType::class);
        $builder->add('mes_de_publicacion', ChoiceType::class);
        $builder->add('ano_de_publicacion', ChoiceType::class);

        $builder->add('imagen', FileType::class);

        // DATA MAPPER
        $builder->setDataMapper($this->fechaDePublicacionDataMapper);

        // DATA TRANSFORMER
        $builder->addModelTransformer();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactEntity::class,
            'attr' => [
                'id' => $this->getBlockPrefix(),
            ],
            // 'validation_groups' => ['contact'],
            'custom_parameters' => [],
        ]);
    }

}
