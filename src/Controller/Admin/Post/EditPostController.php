<?php declare(strict_types=1);

namespace App\Controller\Admin\Post;

use App\Context\Admin\Post\DTO\PostDTO;
use App\Context\Admin\Post\Email\EmailSender;
use App\Context\Admin\Post\Form\Type\PublicacionEditType;
use App\Context\Admin\Post\TextRepository\PostFinder;
use App\Context\Admin\Post\TextRepository\PostPersister;
use App\Context\Admin\Post\Uploader\ImagenUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class EditPostController extends AbstractController
{
    private PostFinder    $postFinder;
    private PostPersister $postPersister;
    private EmailSender            $emailSender;
    private ImagenUploader         $imagenUploader;

    public function __construct(PostFinder    $postFinder,
                                PostPersister $postPersister,
                                EmailSender            $emailSender,
                                ImagenUploader         $imagenUploader)
    {
        $this->postFinder = $postFinder;
        $this->postPersister = $postPersister;
        $this->emailSender = $emailSender;
        $this->imagenUploader = $imagenUploader;
    }

    /**
     * @Route("/admin/post/edit/{id}", name="admin_post_edit")
     */
    public function __invoke(Request $request, int $id)
    {
        $postArray = $this->postFinder->findById($id);
        $postDTO = PostDTO::createFromParams($postArray);

        $form = $this->createForm(PublicacionEditType::class, $postDTO);
        // Aquí todos los datos de la request:
        // dump($_REQUEST); die();
        $form->handleRequest($request);
        // Aquí todos los datos de la request tras mapeo
        // dump($form->getData()); die();

        // Aquí hay parte que estaría mejor encapsularla en un Handler => "S" de SOLID al poder!
        if ($form->isSubmitted() && $form->isValid()) {
            $postDTO = $form->getData();

            $this->postPersister->persist($postDTO);
            $this->imagenUploader->upload($form['image_file']->getData(), $postDTO);
            $this->emailSender->sendModifiedPostEmail($postDTO);

            $this->addFlash('success', 'Publicación editada satisfactoriamente');
            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/post/edit.html.twig', ['form' => $form->createView()]);
    }
}
