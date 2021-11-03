<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Form\Type;

use App\Context\Admin\Post\DTO\PostDTO;
use App\Context\Admin\Post\Form\DataMapper\PublicacionDataMapper;
use App\Context\Admin\Post\Form\DataTransformer\StateDataTransformer;
use App\Context\Admin\Post\Resolver\MesesResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicacionAddType extends AbstractType
{
    private PublicacionDataMapper $publicacionDataMapper;
    private StateDataTransformer  $stateDataTransformer;

    public function __construct(PublicacionDataMapper $publicacionDataMapper,
                                StateDataTransformer  $stateDataTransformer)
    {
        $this->publicacionDataMapper = $publicacionDataMapper;
        $this->stateDataTransformer = $stateDataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', HiddenType::class);

        // Es recomendable que todo lo referente a UX esté en el propio html
        $builder->add('title', TextType::class, [
            'attr' => [
                'placeholder' => 'inserte aquí un título',
            ],
            'help' => '<span class="fa fa-info-circle mt-2"> escoja un título que resuma la publicación</span>',
            'help_html' => true,
        ]);

        $builder->add('body', TextareaType::class);

        // Ver línea 370 Symfony\Component\Form\Extension\Core\Type\ChoiceType para ver los parámetros admitidos
        $states = ['Seleccione Estado' => null, 'Activo' => 'active', 'Desactivado' => 'disabled'];
        $builder->add('state', ChoiceType::class, ['choices' => $states]);

        $builder->add('availability_day', TextType::class, ['mapped' => false]);
        $builder->add('availability_month', ChoiceType::class, ['mapped' => false]);
        $builder->add('availability_year', ChoiceType::class, ['mapped' => false]);

        $builder->add('image', HiddenType::class);
        $builder->add('image_file', FileType::class, ['mapped' => false]);

        // DATA MAPPER
        $builder->setDataMapper($this->publicacionDataMapper);

        // DATA TRANSFORMER
        $builder->get('state')->addModelTransformer($this->stateDataTransformer);

        // LOS 5 FORM EVENTS
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
        $builder->addEventListener(FormEvents::POST_SET_DATA, function () {
            // echo "estoy en post-set-data <br>";
        });
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function () {
            // echo "estoy en pre-submit <br>";
        });
        $builder->addEventListener(FormEvents::SUBMIT, function () {
            // echo "estoy en submit <br>";
        });
        $builder->addEventListener(FormEvents::POST_SUBMIT, function () {
            // echo "estoy en post-submit <br>";
        });
    }

    public function onPreSetData(FormEvent $event)
    {
        // echo "estoy en pre-set-data <br>";

        $form = $event->getForm();
        /** @var PostDTO $data */
        $data = $event->getData();

        // Add years
        $options = $form->get('availability_year')->getConfig()->getOptions();
        $years = [(string)($year = date('Y')) => $year, (string)(++$year) => $year];
        $options['choices'] = $years;
        $form->add('availability_year', ChoiceType::class, $options);

        // Add months
        $options = $form->get('availability_month')->getConfig()->getOptions();
        $months = MesesResolver::resolve();
        $options['choices'] = $months;
        $form->add('availability_month', ChoiceType::class, $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /** @var PostDTO $postDTO */
        $postDTO = $form->getData();

        $view->vars['image_path'] = (!empty($postDTO->getImage())) ? '/uploads/' . $postDTO->getImage() : '';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostDTO::class,
        ]);
    }
}
