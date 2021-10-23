<?php declare(strict_types=1);

namespace App\Context\ContactForm01\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('first_name', TextType::class, ['required' => true]);
        $builder->add('last_name', TextType::class, ['required' => false]);
    }
}
