<?php declare(strict_types=1);

namespace App\Controller\ContactForm;

use App\Context\ContactForm04\DTO\ContactFormDTO;
use App\Context\ContactForm04\Form\Type\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ContactForm04Controller extends AbstractController
{
    /**
     * @Route("/contact-form-04", name="contact_form_04")
     */
    public function __invoke(Request $request)
    {
        // DTO + Validación en archivo yaml

        $contactFormDto = ContactFormDTO::create();
        $form = $this->createForm(ContactFormType::class, $contactFormDto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $this->persist($form->getData());
           return $this->redirectToRoute('contact_form_ok');
        }

        return $this->render('contact_form/contact_form_04/contact_form.html.twig', ['form' => $form->createView()]);
    }

    private function persist(ContactFormDTO $contactFormDTO) : void
    {
        if (!is_dir($dir = __DIR__ . '/../../../tmp')) {
            mkdir($dir, 0755);
        }

        $dto = [
            'first_name' => $contactFormDTO->getFirstName(),
            'last_name' => $contactFormDTO->getLastName(),
        ];

        file_put_contents($dir . '/database.txt', json_encode($dto) . PHP_EOL, FILE_APPEND);
    }
}
