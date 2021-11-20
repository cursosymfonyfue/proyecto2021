<?php declare(strict_types=1);

namespace App\Controller\Admin\Post;

use App\Context\Admin\Post\Repository\PostPersister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class DeletePostController extends AbstractController
{
    private PostPersister $postPersister;

    public function __construct(PostPersister $postPersister)
    {
        $this->postPersister = $postPersister;
    }

    /**
     * @Route("/admin/post/delete/{id}", name="admin_post_delete")
     */
    public function __invoke(Request $request, int $id)
    {
        $this->postPersister->delete($id);

        $this->addFlash('success', 'Publicación eliminada satisfactoriamente');
        return $this->redirectToRoute('admin_post_index');
    }
}
