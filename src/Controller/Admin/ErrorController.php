<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/admin/error", name="error")
     */
    public function index()
    {
        return $this->render('admin/error/index.html.twig', [
            'controller_name' => 'ErrorController',
        ]);
    }
}
