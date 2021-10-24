<?php declare(strict_types=1);

namespace App\Controller\Admin\Publicacion;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class PublicacionIndexController extends AbstractController
{
    /**
     * @Route("/admin/publicacion/", name="admin_publication_index")
     */
    public function __invoke(Request $request)
    {
        $publicaciones = $this->resolvePublicaciones();
        return $this->render('admin/publicacion/index.html.twig', ['publicaciones' => $publicaciones]);
    }

    private function resolvePublicaciones() : array
    {
        // Aquí un finder
        return [];
    }
}
