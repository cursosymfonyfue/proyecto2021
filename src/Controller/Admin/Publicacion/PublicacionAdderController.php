<?php declare(strict_types=1);

namespace App\Controller\Admin\Publicacion;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use App\Context\Admin\Publicacion\Email\EmailSender;
use App\Context\Admin\Publicacion\Form\Type\PublicacionAddType;
use App\Context\Admin\Publicacion\TextRepository\PublicacionesPersister;
use App\Context\Admin\Publicacion\Resolver\NombreDeImagenResolver;
use App\Context\Admin\Publicacion\Uploader\ImagenUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/*
 * NOTAS: $builder->add es una interfaz fluida, esto es permite encadenar varios add: ->add(a)->add(b)->add(c) ....
 *
 * Ejercicios :
 *   - convertir en option buttons en lugar de desplegable el campo estado
 *   - añadir campo categoría tipo desplegable. Categorias: Ordenadores, Deportes, Viajes ...
 *   - añadir validador fecha
 *   - añadir custom validator descripción no contiene ningún e-mail (no debe hallarse el carácter @ en la descripción)
 */

final class PublicacionAdderController extends AbstractController
{
    private PublicacionesPersister $publicacionesPersister;
    private EmailSender            $emailSender;
    private string                 $kernelProjectDir;
    private ImagenUploader         $imagenUploader;

    public function __construct(PublicacionesPersister $publicacionesPersister,
                                EmailSender            $emailSender,
                                string                 $kernelProjectDir,
                                ImagenUploader         $imagenUploader)
    {
        $this->publicacionesPersister = $publicacionesPersister;
        $this->emailSender = $emailSender;
        $this->kernelProjectDir = $kernelProjectDir;
        $this->imagenUploader = $imagenUploader;
    }

    /**
     * @Route("/admin/publicacion/add", name="admin_publicacion_add")
     */
    public function __invoke(Request $request)
    {
        $publicacionDTO = PublicacionDTO::create();

        echo "estoy en antes de crear formulario <br>";
        $form = $this->createForm(PublicacionAddType::class, $publicacionDTO);
        echo "estoy en tras crear formulario <br>";

        $form->handleRequest($request);
        echo "estoy en tras gestionar la request <br>";

        // Aquí hay parte que estaría mejor encapsularla en un Handler => "S" de SOLID al poder!
        if ($form->isSubmitted() && $form->isValid()) {
            $publicacionDTO = $form->getData();

            $this->publicacionesPersister->persist($publicacionDTO);
            $this->imagenUploader->upload($form['imagen_file']->getData(), $publicacionDTO);
            $this->emailSender->enviaEmailNuevaPublicacionCreada($publicacionDTO);

            $this->addFlash('success', 'Publicación creada satisfactoriamente');
            return $this->redirectToRoute('admin_publication_index');
        }

        return $this->render('admin/publicacion/adder.html.twig', ['form' => $form->createView()]);
    }
}
