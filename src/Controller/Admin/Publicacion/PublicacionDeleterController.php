<?php declare(strict_types=1);

namespace App\Controller\Admin\Publicacion;

use App\Context\Admin\Publicacion\TextRepository\PublicacionesPersister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class PublicacionDeleterController extends AbstractController
{
    private PublicacionesPersister $publicacionesPersister;

    public function __construct(PublicacionesPersister $publicacionesPersister)
    {
        $this->publicacionesPersister = $publicacionesPersister;
    }

    /**
     * @Route("/admin/publicacion/delete/{id}", name="admin_publicacion_delete")
     */
    public function __invoke(Request $request, string $id)
    {
        $this->publicacionesPersister->delete($id);

        $this->addFlash('success', 'Publicación eliminada satisfactoriamente');
        return $this->redirectToRoute('admin_publication_index');
    }
}
