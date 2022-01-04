<?php declare(strict_types=1);

namespace App\Controller\Admin\Contact;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    private ContactRepository $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @Route("/admin/contact", name="admin_contact_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $this->contactRepository->findAll(),
        ]);
    }
}
