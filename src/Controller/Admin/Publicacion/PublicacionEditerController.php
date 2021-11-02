<?php declare(strict_types=1);

namespace App\Controller\Admin\Publicacion;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use App\Context\Admin\Publicacion\Email\EmailSender;
use App\Context\Admin\Publicacion\Form\Type\PublicacionEditType;
use App\Context\Admin\Publicacion\TextRepository\PublicacionesFinder;
use App\Context\Admin\Publicacion\TextRepository\PublicacionesPersister;
use App\Context\Admin\Publicacion\Uploader\ImagenUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class PublicacionEditerController extends AbstractController
{
    private PublicacionesFinder    $publicacionesFinder;
    private PublicacionesPersister $publicacionesPersister;
    private EmailSender            $emailSender;
    private ImagenUploader         $imagenUploader;

    public function __construct(PublicacionesFinder    $publicacionesFinder,
                                PublicacionesPersister $publicacionesPersister,
                                EmailSender            $emailSender,
                                ImagenUploader         $imagenUploader)
    {
        $this->publicacionesFinder = $publicacionesFinder;
        $this->publicacionesPersister = $publicacionesPersister;
        $this->emailSender = $emailSender;
        $this->imagenUploader = $imagenUploader;
    }

    /**
     * @Route("/admin/publicacion/edit/{id}", name="admin_publicacion_edit")
     */
    public function __invoke(Request $request, string $id)
    {
        $publicacion = $this->publicacionesFinder->findById($id);
        $publicacionDTO = PublicacionDTO::createFromParams($publicacion);

        $form = $this->createForm(PublicacionEditType::class, $publicacionDTO);
        $form->handleRequest($request);

        // Aquí hay parte que estaría mejor encapsularla en un Handler => "S" de SOLID al poder!
        if ($form->isSubmitted() && $form->isValid()) {
            $publicacionDTO = $form->getData();

            $this->publicacionesPersister->persist($publicacionDTO);
            $this->imagenUploader->upload($form['imagen_file']->getData(), $publicacionDTO);
            $this->emailSender->enviaEmailPublicacionModificada($publicacionDTO);

            $this->addFlash('success', 'Publicación editada satisfactoriamente');
            return $this->redirectToRoute('admin_publication_index');
        }

        return $this->render('admin/publicacion/editer.html.twig', ['form' => $form->createView()]);
    }
}
