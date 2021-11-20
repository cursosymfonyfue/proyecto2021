<?php declare(strict_types=1);

namespace App\Controller\Admin\Post;

use App\Context\Admin\Post\Email\EmailSender;
use App\Context\Admin\Post\Form\Type\PostEditType;
use App\Context\Admin\Post\Repository\PostFinder;
use App\Context\Admin\Post\Repository\PostPersister;
use App\Context\Admin\Post\Uploader\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class EditPostController extends AbstractController
{
    private PostFinder    $postFinder;
    private PostPersister $postPersister;
    private EmailSender   $emailSender;
    private ImageUploader $imageUploader;

    public function __construct(PostFinder    $postFinder,
                                PostPersister $postPersister,
                                EmailSender   $emailSender,
                                ImageUploader $imageUploader)
    {
        $this->postFinder = $postFinder;
        $this->postPersister = $postPersister;
        $this->emailSender = $emailSender;
        $this->imageUploader = $imageUploader;
    }

    /**
     * @Route("/admin/post/edit/{id}", name="admin_post_edit")
     */
    public function __invoke(Request $request, int $id)
    {
        $postEntity = $this->postFinder->findById($id);

        $form = $this->createForm(PostEditType::class, $postEntity);
        // Aquí todos los datos de la request:
        // dump($_REQUEST); die();
        $form->handleRequest($request);
        // Aquí todos los datos de la request tras mapeo
        // dump($form->getData()); die();

        // Aquí hay parte que estaría mejor encapsularla en un Handler => "S" de SOLID al poder!
        if ($form->isSubmitted() && $form->isValid()) {
            $postEntity = $form->getData();

            $this->postPersister->persist($postEntity);
            $this->imageUploader->upload($form['image_file']->getData(), $postEntity);
            $this->emailSender->sendModifiedPostEmail($postEntity);

            $this->addFlash('success', 'Publicación editada satisfactoriamente');
            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/post/edit.html.twig', ['form' => $form->createView()]);
    }
}
