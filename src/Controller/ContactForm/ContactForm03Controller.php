<?php declare(strict_types=1);

namespace App\Controller\ContactForm;

use App\Context\ContactForm\ContactForm03\Form\Type\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ContactForm03Controller extends AbstractController
{
    /**
     * @Route("/contact-form-03", name="contact_form_03")
     */
    public function __invoke(Request $request)
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $this->persist($form->getData());
           return $this->redirectToRoute('contact_form_ok');
        }

        return $this->render('contact_form/contact_form_03/contact_form.html.twig', ['form' => $form->createView()]);
    }

    private function persist(array $data) : void
    {
        if (!is_dir($dir = __DIR__ . '/../../../tmp')) {
            mkdir($dir, 0755);
        }

        $dto = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ];

        file_put_contents($dir . '/database.txt', json_encode($dto) . PHP_EOL, FILE_APPEND);
    }
}
