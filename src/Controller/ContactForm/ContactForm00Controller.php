<?php declare(strict_types=1);

namespace App\Controller\ContactForm;

use App\Context\ContactForm\ContactForm00\Form\Type\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class ContactForm00Controller extends AbstractController
{
    /**
     * @Route("/contact-form-00", name="contact_form_00")
     */
    public function __invoke()
    {
        $form = $this->createForm(ContactFormType::class);
        return $this->render('contact_form/contact_form_00/contact_form.html.twig', ['form' => $form->createView()]);
    }
}
