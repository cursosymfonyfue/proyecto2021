<?php declare(strict_types=1);

namespace App\Controller\Admin\Publicacion;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use App\Context\Admin\Publicacion\Email\EmailSender;
use App\Context\Admin\Publicacion\Form\Type\PublicacionAddType;
use App\Context\Admin\Publicacion\Repository\PublicacionesFinder;
use App\Context\Admin\Publicacion\Repository\PublicacionesPersister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class PublicacionEditerController extends AbstractController
{
    private PublicacionesFinder    $publicacionesFinder;
    private PublicacionesPersister $publicacionesPersister;
    private EmailSender            $emailSender;

    public function __construct(PublicacionesFinder    $publicacionesFinder,
                                PublicacionesPersister $publicacionesPersister,
                                EmailSender            $emailSender)
    {
        $this->publicacionesFinder = $publicacionesFinder;
        $this->publicacionesPersister = $publicacionesPersister;
        $this->emailSender = $emailSender;
    }

    /**
     * @Route("/admin/publicacion/edit/{id}", name="admin_publicacion_edit")
     */
    public function __invoke(Request $request, string $id)
    {
        $publicacion = $this->publicacionesFinder->findById($id);
        $publicacionDTO = PublicacionDTO::createFromParams($publicacion);

        $form = $this->createForm(PublicacionAddType::class, $publicacionDTO);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicacionDTO = $form->getData();

            $this->publicacionesPersister->persist($publicacionDTO);
            $this->emailSender->enviaEmailPublicacionModificada($publicacionDTO);

            $this->addFlash('success', 'Publicación editada satisfactoriamente');
            return $this->redirectToRoute('admin_publication_index');
        }

        return $this->render('admin/publicacion/editer.html.twig', ['form' => $form->createView()]);
    }
}
