<?php declare(strict_types=1);

namespace App\Controller\ContactForm;

use App\Context\ContactForm\ContactForm\DTO\ContactFormDTO;
use App\Context\ContactForm\ContactForm\Email\ContactFormEmailSender;
use App\Context\ContactForm\ContactForm\Form\Type\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ContactFormController extends AbstractController
{
    private ContactFormEmailSender $contactFormEmailSender;

    public function __construct(ContactFormEmailSender $contactFormEmailSender)
    {
        $this->contactFormEmailSender = $contactFormEmailSender;
    }

    /**
     * @Route("/contact-form", name="contact_form")
     */
    public function __invoke(Request $request)
    {
        $contactFormDto = ContactFormDTO::create();
        $form = $this->createForm(ContactFormType::class, $contactFormDto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactFormEmailSender->send($form->getData());
           return $this->redirectToRoute('contact_form_ok');
        }

        return $this->render('contact_form/contact_form/contact_form.html.twig', ['form' => $form->createView()]);
    }
}
