<?php declare(strict_types=1);

namespace App\Context\ContactForm02\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('first_name', TextType::class, [
            'required' => true,
            'constraints' => [
                new NotBlank(),
                ]
        ]);

        $builder->add('last_name', TextType::class, ['required' => false]);
    }
}
