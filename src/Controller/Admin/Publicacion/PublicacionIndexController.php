<?php declare(strict_types=1);

namespace App\Controller\Admin\Publicacion;

use Symfony\Component\HttpFoundation\Request;

final class PublicacionIndexController
{
    /**
     * @Route("/admin/publicacion/", name="admin_publication_index")
     */
    public function __invoke(Request $request)
    {
        return $this->render('admin/publicacion/index.html.twig');
    }
}
