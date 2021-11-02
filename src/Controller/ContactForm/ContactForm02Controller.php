<?php declare(strict_types=1);

namespace App\Controller\ContactForm;

use App\Context\ContactForm\ContactForm02\Form\Type\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ContactForm02Controller extends AbstractController
{
    /**
     * @Route("/contact-form-02", name="contact_form_02")
     */
    public function __invoke(Request $request)
    {
        $form = $this->createForm(ContactFormType::class);

        // Si no llevamos a cabo la gestión de la request ($form->handleRequest($request)):
        // - isSubmitted siempre será FALSE
        // - $form->getData() contendrá siempre null

        // IMPORTANTE: MAPEO DE LA REQUEST A DATA
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           echo "SUBMITTED AND VALID";
        }

        return $this->render('contact_form/contact_form_02/contact_form.html.twig', ['form' => $form->createView()]);
    }
}
