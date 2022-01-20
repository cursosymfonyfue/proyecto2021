<?php

declare(strict_types=1);

namespace App\Controller\ContactForm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class OkController extends AbstractController
{
    /**
     * @Route("/contact-form-ok", name="contact_form_ok")
     */
    public function __invoke(Request $request)
    {
        return $this->render('contact_form/contact_form_ok.html.twig');
    }
}
