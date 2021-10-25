<?php declare(strict_types=1);

namespace App\Context\Admin\Publicacion\Form\Type;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PublicacionEditType extends PublicacionAddType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('id');
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars['alerta'] = 'Atención: está vd. editando un contenido ya existente';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublicacionDTO::class,
        ]);
    }
}
