<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

final class PublicacionEditType extends PublicacionAddType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars['alerta'] = 'Atención: está vd. editando un contenido ya existente';
    }
}
