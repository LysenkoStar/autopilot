<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResourcesController extends AbstractController
{
    /**
     * @Route("/admin/resources", name="resources")
     */
    public function index()
    {
        return $this->render('admin/resources/index.html.twig', [
            'controller_name' => 'ResourcesController',
        ]);
    }
}
