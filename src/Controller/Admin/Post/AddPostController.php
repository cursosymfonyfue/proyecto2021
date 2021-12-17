<?php declare(strict_types=1);

namespace App\Controller\Admin\Post;

use App\Context\Admin\Post\Email\EmailSender;
use App\Context\Admin\Post\Form\Type\PostAddType;
use App\Context\Admin\Post\Repository\PostPersister;
use App\Context\Admin\Post\Resolver\LoggerUserEntityResolver;
use App\Context\Admin\Post\Uploader\ImageUploader;
use App\Entity\Post;
use App\Service\Logger\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/*
 * NOTAS: $builder->add es una interfaz fluida, esto es permite encadenar varios add: ->add(a)->add(b)->add(c) ....
 */
final class AddPostController extends AbstractController
{
    private PostPersister            $postPersister;
    private EmailSender              $emailSender;
    private ImageUploader            $imageUploader;
    private LoggerUserEntityResolver $loggerUserEntityResolver;
    private LoggerService $loggerService;

    public function __construct(PostPersister            $postPersister,
                                EmailSender              $emailSender,
                                ImageUploader            $imageUploader,
                                LoggerUserEntityResolver $loggerUserEntityResolver,
                                LoggerService $loggerService)
    {
        $this->postPersister = $postPersister;
        $this->emailSender = $emailSender;
        $this->imageUploader = $imageUploader;
        $this->loggerUserEntityResolver = $loggerUserEntityResolver;
        $this->loggerService = $loggerService;
    }

    /**
     * @Route("/admin/post/add", name="admin_post_add")
     */
    public function __invoke(Request $request)
    {
        $postEntity = new Post();

        // echo "estoy en antes de crear formulario <br>";
        $form = $this->createForm(PostAddType::class, $postEntity);
        // echo "estoy en tras crear formulario <br>";

        $form->handleRequest($request);
        // echo "estoy en tras gestionar la request <br>";

        // Aquí hay parte que estaría mejor encapsularla en un Handler
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Post $postEntity */
            $postEntity = $form->getData();

            $postEntity->setUser($this->loggerUserEntityResolver->resolve());
            $this->postPersister->persist($postEntity);

            $this->imageUploader->upload($form['image_file']->getData(), $postEntity);
            $this->emailSender->sendNewPostEMail($postEntity);

            $this->addFlash('success', 'Publicación creada satisfactoriamente');

            $this->loggerService->log('Nuevo post curso Symfony FUE ' . date("Y-m-d H:i:s"));

            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/post/add.html.twig', ['form' => $form->createView()]);
    }
}
