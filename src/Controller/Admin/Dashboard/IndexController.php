<?php

declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard", methods={"GET"})
     */
    public function __invoke()
    {
        return $this->render('admin/dashboard/index.html.twig');
    }
}
