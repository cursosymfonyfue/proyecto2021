<?php

declare(strict_types=1);

namespace App\Context\ContactForm\ContactForm\Form\Type;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('full_name', TextType::class, ['property_path' => 'fullName', 'required' => true, 'constraints' => [new NotBlank(null, 'Full name required')]]);
        $builder->add('subject', TextType::class, ['required' => true, 'constraints' => [new NotBlank(null, 'Subject required')]]);
        $builder->add('body', TextType::class, ['required' => true, 'constraints' => [new NotBlank(null, 'Body required')]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
