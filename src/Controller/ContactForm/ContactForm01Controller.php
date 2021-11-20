<?php declare(strict_types=1);

namespace App\Controller\ContactForm;

use App\Context\ContactForm\ContactForm01\Form\Type\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ContactForm01Controller extends AbstractController
{
    /**
     * @Route("/contact-form-01", name="contact_form_01")
     */
    public function __invoke(Request $request)
    {
        $form = $this->createForm(ContactFormType::class);

        // Si no llevamos a cabo la gestión de la request, isSubmitted siempre será FALSE
        // es donde se hace el BIND:
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            echo var_export($form->getData());
        }

        return $this->render('contact_form/contact_form_01/contact_form.html.twig', ['form' => $form->createView()]);
    }
}
