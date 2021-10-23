<?php declare(strict_types=1);

namespace App\Controller\Admin\Publicacion;

use App\Context\Admin\Publication\DTO\PublicationDTO;
use App\Context\Admin\Publication\PublicationAddType;
use Symfony\Component\HttpFoundation\Request;

/*
 * NOTAS: $builder->add es una interfaz fluida, esto es permite encadenar varios add: ->add(a)->add(b)->add(c) ....
 *
 * Ejercicios :
 *   - convertir en option buttons en lugar de desplegable el campo estado
 *   - añadir campo categoría tipo desplegable. Categorias: Ordenadores, Deportes, Viajes ...
 *   - añadir validador fecha
 *   - añadir custom validator descripción no contiene ningún e-mail (no debe hallarse el carácter @ en la descripción)
 */

final class PublicacionAdderController
{
    /**
     * @Route("/admin/publicacion/add", name="admin_publicacion_add")
     */
    public function __invoke(Request $request)
    {
        $publicationDTO = PublicationDTO::create();
        $form = $this->createForm(PublicationAddType::class, $publicationDTO);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persist($form->getData());
            return $this->redirectToRoute('publicacion_ok');
        }

        return $this->render('contact_form/contact_form_04/contact_form.html.twig', ['form' => $form->createView()]);
    }

    private function persist(PublicationDTO $publicationDTO) : void
    {
        if (!is_dir($dir = __DIR__ . '/../../../tmp')) {
            mkdir($dir, 0755);
        }

        $dto = [
            'id' => $publicationDTO->getId(),
            'nombre' => $publicationDTO->getNombre(),
            'descripcion' => $publicationDTO->getDescripcion(),
            'estado' => $publicationDTO->getEstado(),
            'fecha_de_publicacion' => $publicationDTO->getFechaDePublicacion()->format('Y-m-d H:i:s'),
            'imagen' => $publicationDTO->getImagen(),
        ];

        file_put_contents($dir . '/database.txt', json_encode($dto) . PHP_EOL, FILE_APPEND);
    }
}
