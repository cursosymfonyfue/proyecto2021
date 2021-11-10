<?php declare(strict_types=1);

namespace App\Controller\Admin\Post;

use App\Context\Admin\Post\Repository\PostFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class IndexPostController extends AbstractController
{
    private PostFinder $postFinder;

    public function __construct(PostFinder $postFinder)
    {
        $this->postFinder = $postFinder;
    }

    /**
     * @Route("/admin/post/", name="admin_post_index")
     */
    public function __invoke(Request $request)
    {
        $posts = $this->postFinder->findAll();
        return $this->render('admin/post/index.html.twig', ['posts' => $posts]);
    }
}
