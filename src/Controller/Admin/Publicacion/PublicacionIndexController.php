<?php declare(strict_types=1);

namespace App\Controller\Admin\Publicacion;

use App\Context\Admin\Publicacion\Repository\PublicacionesFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class PublicacionIndexController extends AbstractController
{
    private PublicacionesFinder $publicacionesFinder;

    public function __construct(PublicacionesFinder $publicacionesFinder)
    {
        $this->publicacionesFinder = $publicacionesFinder;
    }

    /**
     * @Route("/admin/publicacion/", name="admin_publication_index")
     */
    public function __invoke(Request $request)
    {
        $publicaciones = $this->publicacionesFinder->findAll();
        return $this->render('admin/publicacion/index.html.twig', ['publicaciones' => $publicaciones]);
    }
}
