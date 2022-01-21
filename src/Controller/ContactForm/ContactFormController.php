<?php

declare(strict_types=1);

namespace App\Controller\ContactForm;

use App\Context\ContactForm\ContactForm\DTO\ContactFormDTO;
use App\Context\ContactForm\ContactForm\Email\ContactFormEmailSender;
use App\Context\ContactForm\ContactForm\Form\Type\ContactFormType;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ContactFormController extends AbstractController
{
    private ContactFormEmailSender $contactFormEmailSender;
    private ContactRepository $contactRepository;

    public function __construct(ContactFormEmailSender $contactFormEmailSender, ContactRepository $contactRepository)
    {
        $this->contactFormEmailSender = $contactFormEmailSender;
        $this->contactRepository = $contactRepository;
    }

    /**
     * @Route("/contact-form", name="contact_form")
     */
    public function __invoke(Request $request)
    {
        $contactEntity = new Contact();
        $form = $this->createForm(ContactFormType::class, $contactEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Estas líneas deberían ir encapsuladas en un handler
            // La misma lógica podría ser reaprovechado en una api por ejemplo y evitaríamos duplicidad de código
            $this->contactRepository->save($contactEntity);
            $this->contactFormEmailSender->send($contactEntity);

            return $this->redirectToRoute('contact_form_ok');
        }

        return $this->render('contact_form/contact_form/contact_form.html.twig', ['form' => $form->createView()]);
    }
}
