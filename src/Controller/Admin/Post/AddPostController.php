<?php declare(strict_types=1);

namespace App\Controller\Admin\Post;

use App\Context\Admin\Post\DTO\PostDTO;
use App\Context\Admin\Post\Email\EmailSender;
use App\Context\Admin\Post\Form\Type\PublicacionAddType;
use App\Context\Admin\Post\TextRepository\PostPersister;
use App\Context\Admin\Post\Uploader\ImagenUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/*
 * NOTAS: $builder->add es una interfaz fluida, esto es permite encadenar varios add: ->add(a)->add(b)->add(c) ....
 */

final class AddPostController extends AbstractController
{
    private PostPersister  $postPersister;
    private EmailSender    $emailSender;
    private ImagenUploader $imagenUploader;

    public function __construct(PostPersister  $postPersister,
                                EmailSender    $emailSender,
                                ImagenUploader $imagenUploader)
    {
        $this->postPersister = $postPersister;
        $this->emailSender = $emailSender;
        $this->imagenUploader = $imagenUploader;
    }

    /**
     * @Route("/admin/post/add", name="admin_post_add")
     */
    public function __invoke(Request $request)
    {
        $postDTO = PostDTO::create();

        // echo "estoy en antes de crear formulario <br>";
        $form = $this->createForm(PublicacionAddType::class, $postDTO);
        // echo "estoy en tras crear formulario <br>";

        $form->handleRequest($request);
        // echo "estoy en tras gestionar la request <br>";

        // Aquí hay parte que estaría mejor encapsularla en un Handler
        if ($form->isSubmitted() && $form->isValid()) {
            $postDTO = $form->getData();

            $this->postPersister->persist($postDTO);
            $this->imagenUploader->upload($form['image_file']->getData(), $postDTO);
            $this->emailSender->sendNewPostEMail($postDTO);

            $this->addFlash('success', 'Publicación creada satisfactoriamente');
            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/post/add.html.twig', ['form' => $form->createView()]);
    }
}
